<?php

declare(strict_types=1);

namespace App\Http\Controllers\Protected;

use App\Http\Controllers\Controller;
use App\Services\Google\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function adminOnly(string $path, Request $request): Response
    {
        return $this->generateResponse($path, $request);
    }

    public function authenticatedOnly(string $path, Request $request): Response
    {
        return $this->generateResponse($path, $request);
    }

    public function openFileFromDrive(string $fileId): Response
    {
        $file = GoogleDrive::getFileMetadata($fileId, ['fields' => 'name, mimeType,fileExtension']);
        $response = GoogleDrive::getFileContent($fileId);
        $content = $response->getBody()->getContents();

        return response($content, 200, [
            'Content-Type' => $file->getMimeType(),
            'Content-Disposition' => 'inline; filename="'.basename($file->getName()).'"; filename*=UTF-8\'\''.rawurlencode($file->getName()),
        ]);
    }

    private function generateResponse(string $path, Request $request): Response
    {
        $download = $request->query('download');
        $contents = Storage::get($path);
        $mimeType = Storage::mimeType($path);

        $response = new Response($contents);
        $response->headers->set('Content-Type', $mimeType);
        $response->headers->set('Content-Disposition', $download ? 'attachment' : 'inline');

        return $response;
    }
}
