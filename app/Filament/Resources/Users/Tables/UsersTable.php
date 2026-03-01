<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')
                    ->searchable(),
                TextColumn::make('role'),
                TextColumn::make('branch.name')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('toggleActive')
                    ->label(fn(User $record): string => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn(User $record): string => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn(User $record): string => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn(User $record): string => $record->is_active ? 'Deactivate User' : 'Activate User')
                    ->modalDescription(fn(User $record): string => $record->is_active
                        ? 'This user will be deactivated and logged out immediately.'
                        : 'This user will be activated and can log in again.')
                    ->action(function (User $record): void {
                        $isDeactivating = $record->is_active;

                        $record->update(['is_active' => ! $record->is_active]);

                        if ($isDeactivating) {
                            DB::table('sessions')
                                ->where('user_id', $record->id)
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
                        ->modalDescription('Selected users will be deactivated and logged out immediately.')
                        ->action(function (Collection $records): void {
                            $ids = $records->pluck('id');

                            $records->each->update(['is_active' => false]);

                            DB::table('sessions')
                                ->whereIn('user_id', $ids)
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
}
