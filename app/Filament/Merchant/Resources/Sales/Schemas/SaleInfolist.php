<?php

namespace App\Filament\Merchant\Resources\Sales\Schemas;

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
                TextEntry::make('user.id')
                    ->numeric(),
                TextEntry::make('product.name')
                    ->numeric(),
                TextEntry::make('flavor.name')
                    ->numeric(),
                TextEntry::make('size'),
                TextEntry::make('qty')
                    ->numeric(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('sale_date')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
