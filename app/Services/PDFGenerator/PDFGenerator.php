<?php

declare(strict_types=1);

namespace App\Services\PDFGenerator;

use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use App\Services\Google\GoogleDrive;
use Google\Service\Drive\DriveFile;
use Google\Service\Exception;
use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Exceptions\NativeFunctionErrored;
use Gotenberg\Gotenberg;
use Gotenberg\Stream;
use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\ResponseInterface;

final class PDFGenerator
{
    public static function generateForClient(
        PDFTemplate $template,
        array $destination,
        string $filename,
        Person $person,
        Arrayable|array $data = [],
    ): string {
        $folders = [];

        foreach ($destination as $folder) {
            if ($folder === '{full_name}') {
                $folders[] = $person->lastname_firstname;
            } else {
                $folders[] = $folder;
            }
        }

        return self::generate(
            template: $template,
            destination: $folders,
            filename: $filename,
            data: $data,
        );
    }

    /**
     * @param  list<string>  $data
     *
     * @throws \RuntimeException
     */
    public static function generateInMemory(
        PDFTemplate $template,
        string $filename,
        Arrayable|array $data = [],
    ): ResponseInterface {
        try {
            $content = view(sprintf('pdf.%s.content', $template->value), $data)->render();
            $header = view(sprintf('pdf.%s.header', $template->value), $data)->render();
            $footer = view(sprintf('pdf.%s.footer', $template->value), $data)->render();
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                message: sprintf('Error rendering PDF template "%s": %s', $template->value, $e->getMessage()),
                previous: $e
            );
        }

        try {
            $response = Gotenberg::chromium(config('app.gotenberg_url'))
                ->pdf()
                ->outputFilename($filename)
                ->paperSize('210mm', '297mm')
                ->margins(...$template->getMargins())
                ->header(Stream::string('header.html', $header))
                ->footer(Stream::string('footer.html', $footer))
                ->html(Stream::string('index.html', $content));

            return Gotenberg::send($response);
        } catch (NativeFunctionErrored|GotenbergApiErrored $e) {
            throw new \RuntimeException(
                message: sprintf('Error generating PDF for template "%s": %s', $template->value, $e->getMessage()),
                previous: $e
            );
        }
    }

    /**
     * @param  list<string>  $data
     *
     * @throws \RuntimeException
     */
    private static function generate(
        PDFTemplate $template,
        array $destination,
        string $filename,
        Arrayable|array $data = [],
    ): string {
        try {
            $content = view(sprintf('pdf.%s.content', $template->value), $data)->render();
            $header = view(sprintf('pdf.%s.header', $template->value), $data)->render();
            $footer = view(sprintf('pdf.%s.footer', $template->value), $data)->render();
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                message: sprintf('Error rendering PDF template "%s": %s', $template->value, $e->getMessage()),
                previous: $e
            );
        }

        try {
            $response = Gotenberg::chromium(config('app.gotenberg_url'))
                ->pdf()
                ->outputFilename($filename)
                ->paperSize('210mm', '297mm')
                ->margins(...$template->getMargins())
                ->header(Stream::string('header.html', $header))
                ->footer(Stream::string('footer.html', $footer))
                ->html(Stream::string('index.html', $content));

            $metadata = new DriveFile;
            $metadata->setName($filename);
            $metadata->setMimeType('application/pdf');

            $file = GoogleDrive::createFile(
                metadata: $metadata,
                fileContents: $response->getBody()->getContents(),
                folders: $destination,
                rootFolderId: Season::current()->first()->drive_id,
            );

            return $file->getId();
        } catch (NativeFunctionErrored|Exception $e) {
            throw new \RuntimeException(
                message: sprintf('Error generating PDF for template "%s": %s', $template->value, $e->getMessage()),
                previous: $e
            );
        }
    }
}
