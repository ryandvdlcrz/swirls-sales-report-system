<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->confirmed()
                    ->maxLength(255),

                TextInput::make('password_confirmation')
                    ->password()
                    ->revealable()
                    ->label('Confirm Password')
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(false),

                Select::make('role')
                    ->options(['admin' => 'Admin', 'merchant' => 'Merchant'])
                    ->default('merchant')
                    ->required()
                    ->native(false),

                Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->required()
                            ->unique('branches', 'code')
                            ->maxLength(255),
                        TextInput::make('location')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionAction(
                        fn(Action $action) => $action->modalHeading('Create Branch')
                    ),
            ]);
    }
}
