<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Sales Trend by Branch';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    public ?string $filter = null;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return Branch::pluck('name', 'id')->toArray();
    }

    protected function getData(): array
    {
        $user = Auth::user();
        $selectedBranchId = $this->filter;

        $query = Sale::query();

        if ($user->role !== 'admin') {
            $query->where('branch_id', $user->branch_id);
        } elseif ($selectedBranchId) {
            $query->where('branch_id', $selectedBranchId);
        }

        $sales = (clone $query)
            ->selectRaw('DATE_FORMAT(sale_date, "%Y-%m") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Build range from first sale to now
        $firstSale = (clone $query)->orderBy('sale_date')->first();

        if (!$firstSale) {
            return ['datasets' => [], 'labels' => []];
        }

        $start = Carbon::parse($firstSale->sale_date)->startOfMonth();
        $end = Carbon::now()->startOfMonth();

        $labels = [];
        $amounts = [];

        while ($start->lte($end)) {
            $key = $start->format('Y-m');
            $labels[] = $start->format('M Y');
            $amounts[] = isset($sales[$key]) ? (float) $sales[$key]->total : 0;
            $start->addMonth();
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales (₱)',
                    'data'            => $amounts,
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
