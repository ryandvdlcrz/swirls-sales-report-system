<?php

namespace App\Filament\Merchant\Resources\Sales;

use App\Filament\Merchant\Resources\Sales\Pages;
use App\Models\Sale;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    public static function getEloquentQuery(): Builder
    {
        // Filter by user_id for logged-in merchant and eager load relationships
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id())
            ->with(['product', 'flavor', 'branch']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Component::make('textInput')
                    ->name('product')
                    ->label('Product')
                    ->required(),

                Component::make('textInput')
                    ->name('flavor')
                    ->label('Flavor')
                    ->required(),

                Component::make('textInput')
                    ->name('size')
                    ->label('Size')
                    ->required(),

                Component::make('textInput')
                    ->name('qty')
                    ->label('Quantity')
                    ->numeric()
                    ->required(),

                Component::make('textInput')
                    ->name('total_amount')
                    ->label('Total Amount')
                    ->numeric()
                    ->prefix('₱')
                    ->required(),

                Component::make('datePicker')
                    ->name('sale_date')
                    ->label('Sale Date')
                    ->required(),
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
                    ->date()
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
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
