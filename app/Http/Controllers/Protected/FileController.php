<?php

declare(strict_types=1);

namespace App\Http\Controllers\Protected;

use App\Http\Controllers\Controller;
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
