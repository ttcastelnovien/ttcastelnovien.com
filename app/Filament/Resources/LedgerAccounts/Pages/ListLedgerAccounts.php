<?php

namespace App\Filament\Resources\LedgerAccounts\Pages;

use App\Filament\Resources\LedgerAccounts\LedgerAccountResource;
use App\Models\Accounting\LedgerAccount;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLedgerAccounts extends ListRecords
{
    protected static string $resource = LedgerAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    if (empty($data['code']) && ! empty($data['parent_id'])) {
                        $parent = LedgerAccount::query()->find($data['parent_id']);

                        if ($parent !== null) {
                            $data['code'] = LedgerAccount::nextAccountCode($parent);
                        }
                    }

                    return $data;
                }),
        ];
    }
}
