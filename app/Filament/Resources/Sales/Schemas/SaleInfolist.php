<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('branch.name')
                    ->numeric(),
                TextEntry::make('product.name')
                    ->label('Product Name'),
                TextEntry::make('flavor.name')
                    ->label('Flavor'),
                TextEntry::make('size'),
                TextEntry::make('qty')
                    ->numeric(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('sale_date')
                    ->dateTime(),
            ]);
    }
}
