<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Licence\Licence;
use App\Services\PDFGenerator\PDFGenerator;
use App\Services\PDFGenerator\PDFTemplate;
use Illuminate\Support\Str;

class GenerateLicenceFormController extends Controller
{
    public function __invoke(Licence $licence)
    {
        $filename = Str::snake(sprintf('formulaire_licence%s%s', $licence->person->last_name, $licence->person->first_name));

        $response = PDFGenerator::generateInMemory(
            template: PDFTemplate::FORMULAIRE_LICENCE,
            filename: $filename,
            data: [
                'licence' => $licence,
            ],
        );

        return response(
            $response->getBody()->getContents(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s";', $filename),
            ],
        );
    }
}
