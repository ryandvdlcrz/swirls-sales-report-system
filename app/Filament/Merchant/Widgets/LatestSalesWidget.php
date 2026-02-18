<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class LatestSalesWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Sale::query()
                    ->where('user_id', Auth::id())
                    ->with(['product', 'flavor', 'branch'])
                    ->latest('sale_date')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('sale_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product'),

                Tables\Columns\TextColumn::make('flavor.name')
                    ->label('Flavor'),

                Tables\Columns\TextColumn::make('size'),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Qty'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Amount')
                    ->money('PHP'),
            ]);
    }
}
