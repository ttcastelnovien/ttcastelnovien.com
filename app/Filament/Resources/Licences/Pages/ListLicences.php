<?php

namespace App\Filament\Resources\Licences\Pages;

use App\Enums\LicenceCategory;
use App\Filament\Resources\Licences\LicenceResource;
use App\Models\HumanResource\Person;
use App\Models\Licence\LicenceFee;
use App\Models\Meta\Season;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLicences extends ListRecords
{
    protected static string $resource = LicenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $season = Season::current()->first();
                    $person = Person::query()->findOrFail($data['person_id']);
                    $licenceType = $data['licence_type'];
                    $category = LicenceCategory::fromBirthDate($person->birth_date, $season);

                    $licenceFee = LicenceFee::query()
                        ->whereJsonContains('licence_types', $licenceType)
                        ->whereJsonContains('licence_categories', $category)
                        ->where('season_id', $season->id)
                        ->firstOrFail();

                    $data['licence_fee_id'] = $licenceFee->id;

                    return $data;
                }),
        ];
    }
}
