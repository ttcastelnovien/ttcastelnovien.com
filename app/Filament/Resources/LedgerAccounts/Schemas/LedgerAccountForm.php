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
                TextInput::make('code')
                    ->label('Code')
                    ->required(),
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Select::make('parent_id')
                    ->label('Compte parent')
                    ->relationship(
                        name: 'parent',
                        modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('code'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (LedgerAccount $account) => $account->full_name)
                    ->searchable(['code', 'name']),
            ])->columns(1);
    }
}
