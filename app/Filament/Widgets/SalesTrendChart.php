<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesTrendChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Sales Trend (Last 7 Days)';

    protected int | string | array $columnSpan = 1;


    protected function getType(): string
    {
        return 'line';
    }

    // ✅ Remove nested array structure — return only branch IDs as valid filters
    protected function getFilters(): ?array
    {
        return Branch::pluck('name', 'id')->toArray();
    }

    protected function getData(): array
    {
        $user = Auth::user();
        $selectedBranchId = $this->filter; // ✅ Filament v4 passes selected filter via `$this->filter`

        $query = Sale::query();

        // ✅ Filter logic
        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        } elseif ($selectedBranchId) {
            $query->where('branch_id', $selectedBranchId);
        }

        $dates = collect(range(6, 0))->map(fn($i) => Carbon::now()->subDays($i));

        $salesData = $dates->map(function ($date) use ($query) {
            return (clone $query)
                ->whereDate('sale_date', $date)
                ->sum('total_amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Total Sales (₱)',
                    'data' => $salesData->values(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $dates->map(fn($d) => $d->format('M d'))->toArray(),
        ];
    }
}
