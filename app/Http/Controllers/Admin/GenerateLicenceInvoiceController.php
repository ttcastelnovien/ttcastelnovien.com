<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\SupportingDocumentType;
use App\Http\Controllers\Controller;
use App\Models\Accounting\AnalyticAccount;
use App\Models\Accounting\Journal;
use App\Models\Accounting\JournalEntry;
use App\Models\Accounting\LedgerAccount;
use App\Models\Accounting\SupportingDocument;
use App\Models\Licence\Licence;
use App\Models\Licence\LicenceDiscount;
use App\Services\PDFGenerator\PDFGenerator;
use App\Services\PDFGenerator\PDFTemplate;
use Cknow\Money\Money;
use Illuminate\Support\Str;

class GenerateLicenceInvoiceController extends Controller
{
    public function __invoke(Licence $licence)
    {
        $documentType = SupportingDocumentType::FACTURE_CLIENT;
        $filename = Str::snake(sprintf('facture_licence%s%s', $licence->person->lastname, $licence->person->firstname));
        $invoiceNumber = SupportingDocument::nextDocumentReference($documentType);
        $freeAmount = new Money(0, 'EUR');

        $totalToPay = $licence->amount;
        $licence->licenceDiscounts()->each(function (LicenceDiscount $discount) use (&$totalToPay) {
            if ($discount->type->invoice_deductible) {
                $totalToPay = $totalToPay->subtract($discount->amount);
            }
        });
        $finalAmount = $totalToPay->isNegative() ? $freeAmount : $totalToPay;

        $parents = [];
        if ($licence->is_minor) {
            $licence->person->parents()->each(function ($parent) use (&$parents) {
                $parents[] = sprintf('%s %s', $parent->sex->getPrefix(), $parent->firstname_lastname);
            });
        }

        $fileId = PDFGenerator::generateForClient(
            template: PDFTemplate::FACTURE,
            destination: PDFTemplate::FACTURE->getDestination(),
            filename: $filename,
            person: $licence->person,
            data: [
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $licence->created_at->isoFormat('DD MMM Y'),
                'invoice_due_date' => $licence->created_at->addDays(30)->isoFormat('DD MMM Y'),
                'client_designation' => sprintf('%s %s', $licence->person->sex->getPrefix(), $licence->person->firstname_lastname),
                'secondary_client_designation' => count($parents) > 0 ? implode(' & ', $parents) : null,
                'client_address_line_1' => $licence->person->address_line_1,
                'client_address_line_2' => $licence->person->address_line_2,
                'client_address_line_3' => $licence->person->address_line_3,
                'client_address_zipcode_city' => sprintf('%s %s', $licence->person->postal_code, $licence->person->city),
                'lines' => [
                    [
                        'designation' => sprintf('Cotisation %s', $licence->season->years),
                        'description' => sprintf('%s - %s', $licence->category->getLabel(), $licence->type->getLabel()),
                        'amount' => $finalAmount->formatByIntl(),
                        'quantity' => 1,
                        'total_amount' => $finalAmount,
                    ],
                ],
                'totals' => [
                    'ht' => $finalAmount,
                    'ttc' => $finalAmount,
                ],
            ],
        );

        $invoice = SupportingDocument::query()->create([
            'type' => $documentType,
            'reference' => $invoiceNumber,
            'total_amount' => $finalAmount,
            'date' => $licence->created_at,
            'due_date' => $licence->created_at->addDays(30),
            'file' => $fileId,
            'journal_id' => Journal::query()->whereCode('VEN1')->firstOrFail()->id,
            'person_id' => $licence->person_id,
        ]);

        /** @var JournalEntry $journalEntry */
        $journalEntry = $invoice->journalEntries()->create([
            'date' => $licence->created_at,
            'name' => sprintf('Cotisation %s', $licence->season->years),
            'description' => sprintf('%s - %s', $licence->category->getLabel(), $licence->type->getLabel()),
            'credit' => $finalAmount,
            'ledger_account_id' => LedgerAccount::query()->whereCode('7560000')->firstOrFail()->id,
            'journal_id' => Journal::query()->whereCode('VEN1')->firstOrFail()->id,
            'client_ledger_account_id' => $licence->person->client_ledger_account_id,
            'supporting_document_id' => $invoice->id,
            'reconciled' => false,
        ]);

        $journalEntry->analyticAccountsEntries()->create([
            'analytic_account_id' => AnalyticAccount::query()->whereName('Cotisations')->firstOrFail()->id,
            'amount' => $finalAmount,
        ]);

        $licence->invoice()->associate($invoice)->save();

        return redirect()->back()->with('success', 'La facture a été générée avec succès.');
    }
}
