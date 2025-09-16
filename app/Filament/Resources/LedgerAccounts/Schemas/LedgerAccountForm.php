<?php

namespace App\Filament\Resources\LedgerAccounts\Schemas;

use App\Models\Accounting\LedgerAccount;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LedgerAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('code')
                    ->label('Code')
                    ->length(7),
                Select::make('parent_id')
                    ->label('Compte parent')
                    ->nullable()
                    ->relationship(name: 'parent', titleAttribute: 'fullname')
                    ->getSearchResultsUsing(function (Select $component, string $search): array {
                        $terms = preg_split('/\s+/', trim($search), -1, PREG_SPLIT_NO_EMPTY);
                        $query = LedgerAccount::query();

                        foreach ($terms as $term) {
                            if (preg_match('/^\d+$/', $term)) {
                                $query->where('code', 'ilike', "$term%");
                            } else {
                                $query->where('name', 'ilike', "%$term%");
                            }
                        }

                        if ($record = $component->getRecord()) {
                            $query->where($record->getQualifiedKeyName(), '!=', $record->getKey());
                        }

                        return $query
                            ->limit(20)
                            ->orderBy('code')
                            ->pluck('fullname', 'id')
                            ->all();
                    })
                    ->searchable(),
            ])->columns(1);
    }
}
