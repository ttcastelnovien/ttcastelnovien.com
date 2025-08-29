<?php

namespace App\Filament\Resources\People\Pages;

use App\Filament\Resources\People\PersonResource;
use App\Models\Accounting\LedgerAccount;
use App\Models\HumanResource\Person;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPeople extends ListRecords
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function (Person $record) {
                    $parentAccount = LedgerAccount::query()->whereCode('4111000')->firstOrFail();

                    LedgerAccount::query()->createOrFirst(
                        attributes: ['name' => $record->lastname_firstname],
                        values: [
                            'name' => $record->lastname_firstname,
                            'code' => LedgerAccount::nextAccountCode($parentAccount),
                            'parent_id' => $parentAccount->id,
                        ],
                    );
                }),
        ];
    }
}
