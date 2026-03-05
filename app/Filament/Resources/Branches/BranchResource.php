<?php

namespace App\Filament\Resources\Branches;

use App\Filament\Resources\Branches\Pages\CreateBranch;
use App\Filament\Resources\Branches\Pages\EditBranch;
use App\Filament\Resources\Branches\Pages\ListBranches;
use App\Filament\Resources\Branches\Pages\ViewBranch;
use App\Filament\Resources\Branches\Schemas\BranchInfolist; // Add this
use App\Models\Branch;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static \UnitEnum|string|null $navigationGroup = 'Management';

    protected static ?string $navigationLabel = 'Branches';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Branch Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(4)
                    ->hint('Format: B001, B002, etc.')
                    ->placeholder('B001')
                    ->regex('/^B\d{3}$/'),

                TextInput::make('location')
                    ->required()
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function infolist(Schema $schema): Schema // Add this
    {
        return BranchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Branch Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location')
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('toggleActive')
                    ->label(fn(Branch $record): string => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn(Branch $record): string => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn(Branch $record): string => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn(Branch $record): string => $record->is_active ? 'Deactivate Branch' : 'Activate Branch')
                    ->modalDescription(fn(Branch $record): string => $record->is_active
                        ? 'This branch will be marked as inactive. The assigned merchant will be logged out immediately.'
                        : 'This branch will be marked as active again. The assigned merchant will be able to log in.')
                    ->action(function (Branch $record): void {
                        $isDeactivating = $record->is_active;

                        $record->update(['is_active' => ! $record->is_active]);

                        if ($isDeactivating && $record->user !== null) {
                            DB::table('sessions')
                                ->where('user_id', $record->user->id)
                                ->delete();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalDescription('The merchant of each selected branch will be logged out immediately.')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);

                            $userIds = $records
                                ->filter(fn(Branch $branch) => $branch->user !== null)
                                ->map(fn(Branch $branch) => $branch->user->id);

                            DB::table('sessions')
                                ->whereIn('user_id', $userIds)
                                ->delete();
                        }),

                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->update(['is_active' => true])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBranches::route('/'),
            'create' => CreateBranch::route('/create'),
            'view'   => ViewBranch::route('/{record}'),
            'edit'   => EditBranch::route('/{record}/edit'),
        ];
    }
}
