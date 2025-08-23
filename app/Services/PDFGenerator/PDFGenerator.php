<?php

declare(strict_types=1);

namespace App\Services\PDFGenerator;

use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Exceptions\NativeFunctionErrored;
use Gotenberg\Exceptions\NoOutputFileInResponse;
use Gotenberg\Gotenberg;
use Gotenberg\Stream;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Storage;

use function Illuminate\Filesystem\join_paths;

final class PDFGenerator
{
    /**
     * @throws \RuntimeException
     */
    public static function generate(PDFTemplate $template, Arrayable|array $data = []): string
    {
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

        $directoryCreated = Storage::disk('pdfs')->makeDirectory($template->value);

        if (! $directoryCreated) {
            throw new \RuntimeException(
                message: sprintf('Error creating directory for PDF template "%s"', $template->value),
            );
        }

        try {
            $filename = Gotenberg::save(
                request: Gotenberg::chromium(config('app.gotenberg_url'))
                    ->pdf()
                    ->paperSize('210mm', '297mm')
                    ->margins(...$template->getMargins())
                    ->header(Stream::string('header.html', $header))
                    ->footer(Stream::string('footer.html', $footer))
                    ->html(Stream::string('index.html', $content)),
                dirPath: Storage::disk('pdfs')->path($template->value),
            );

            return Storage::disk('pdfs')->path(join_paths($template->value, $filename));
        } catch (GotenbergApiErrored|NativeFunctionErrored|NoOutputFileInResponse $e) {
            throw new \RuntimeException(
                message: sprintf('Error generating PDF for template "%s": %s', $template->value, $e->getMessage()),
                previous: $e
            );
        }
    }
}
