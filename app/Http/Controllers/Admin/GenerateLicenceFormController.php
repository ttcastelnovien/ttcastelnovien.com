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
        return PDFGenerator::generateInMemory(
            template: PDFTemplate::FORMULAIRE_LICENCE,
            filename: Str::snake(sprintf('formulaire_licence%s%s', $licence->person->last_name, $licence->person->first_name)),
            data: [
                'licence' => $licence,
            ],
        );
    }
}
