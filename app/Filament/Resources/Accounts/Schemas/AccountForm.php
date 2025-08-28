<?php

namespace App\Filament\Resources\Accounts\Schemas;

use App\Models\Accounting\Account;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccountForm
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
                    ->getOptionLabelFromRecordUsing(fn (Account $account) => $account->full_name)
                    ->searchable(['code', 'name']),
            ])->columns(1);
    }
}
