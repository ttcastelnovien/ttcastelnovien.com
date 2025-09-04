<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\MailObject;
use App\Http\Controllers\Controller;
use App\Models\HumanResource\Person;
use App\Models\Licence\Licence;
use App\Services\Mailer\Recipient;
use App\Services\Mailer\TransactionalMailer;
use App\Services\PDFGenerator\PDFGenerator;
use App\Services\PDFGenerator\PDFTemplate;
use Illuminate\Support\Str;

class GenerateLicenceAttestationController extends Controller
{
    public function __invoke(Licence $licence)
    {
        $filename = Str::snake(sprintf('attestation_licence%s%s', $licence->person->last_name, $licence->person->first_name));

        $response = PDFGenerator::generateInMemory(
            template: PDFTemplate::ATTESTATION_LICENCE,
            filename: $filename,
            data: [
                'licence' => $licence,
            ],
        );

        $recipients = [];

        if ($licence->person->email !== null) {
            $recipients[] = new Recipient(
                email: $licence->person->email,
                name: $licence->person->full_name,
            );
        }

        if ($licence->person->parents->isNotEmpty()) {
            $licence->person->parents->each(function (Person $parent) use (&$recipients) {
                if ($parent->email !== null) {
                    $recipients[] = new Recipient(
                        email: $parent->email,
                        name: $parent->full_name,
                    );
                }
            });
        }

        if (count($recipients) === 0) {
            return redirect()->back()->with('error', 'Aucune adresse email trouvée pour cette licence.');
        }

        TransactionalMailer::send(
            object: MailObject::ATTESTATION_LICENCE,
            recipients: $recipients,
            data: [
                'firstname' => $licence->person->first_name,
            ],
            attachments: [
                ['name' => $filename.'.pdf', 'contents' => $response->getBody()->getContents()],
            ]
        );

        return redirect()->back()->with('success', 'Email envoyé avec succès.');
    }
}
