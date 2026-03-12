<?php

namespace App\Filament\Merchant\Resources\Sales;

use App\Filament\Merchant\Resources\Sales\Pages;
use App\Models\Sale;
use BackedEnum;
use Filament\Forms;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\ViewAction;


class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id())
            ->with(['product', 'flavor', 'branch']);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('branch.name')
                    ->label('Name'),

                TextEntry::make('product.name')
                    ->label('Product Name'),

                TextEntry::make('flavor.name')
                    ->label('Flavor'),

                TextEntry::make('size')
                    ->label('Size'),

                TextEntry::make('qty')
                    ->label('Qty'),

                TextEntry::make('total_amount')
                    ->label('Total amount')
                    ->money('PHP'),

                TextEntry::make('sale_date')
                    ->label('Sale date')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Branch')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('flavor.name')
                    ->label('Flavor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('size')
                    ->searchable(),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Quantity')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->money('PHP')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->query(fn(Builder $query): Builder => $query->whereDate('sale_date', today()))
                    ->label('Today'),

                Tables\Filters\Filter::make('this_week')
                    ->query(fn(Builder $query): Builder => $query->whereBetween('sale_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]))
                    ->label('This Week'),

                Tables\Filters\Filter::make('this_month')
                    ->query(fn(Builder $query): Builder => $query->whereMonth('sale_date', now()->month)
                        ->whereYear('sale_date', now()->year))
                    ->label('This Month'),

                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('sale_date', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('sale_date', '<=', $date),
                            );
                    })
                    ->label('Date Range'),
            ])
            ->recordActions([
            ])
            ->defaultSort('sale_date', 'desc')
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'view' => Pages\ViewSale::route('/{record}'),
            
        ];
    }
}
