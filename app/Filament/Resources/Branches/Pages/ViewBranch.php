<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Resources\Branches\BranchResource;
use App\Filament\Resources\Branches\Widgets\BranchProductChart;
use App\Filament\Resources\Branches\Widgets\BranchSalesTable;
use App\Filament\Resources\Branches\Widgets\BranchStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBranch extends ViewRecord
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
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
