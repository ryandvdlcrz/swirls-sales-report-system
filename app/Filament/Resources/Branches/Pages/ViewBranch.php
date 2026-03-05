<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Resources\Branches\BranchResource;
use App\Filament\Resources\Branches\Widgets\BranchProductChart;
use App\Filament\Resources\Branches\Widgets\BranchSalesTable;
use App\Filament\Resources\Branches\Widgets\BranchStatsOverview;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewBranch extends ViewRecord
{
    protected static string $resource = BranchResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BranchStatsOverview::make(['record' => $this->record]),
            BranchProductChart::make(['record' => $this->record]),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            BranchSalesTable::make(['record' => $this->record]),
        ];
    }
}
