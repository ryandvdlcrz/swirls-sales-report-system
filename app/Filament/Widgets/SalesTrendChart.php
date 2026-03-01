<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Sales Trend';

    protected int | string | array $columnSpan = 1;

    public ?string $filter = 'week';

    public ?string $branchId = null;

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today (Hourly)',
            'week'  => 'Last 7 Days',
            'month' => 'This Month',
            'year'  => 'This Year',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('filterBranch')
                ->label(
                    fn() => $this->branchId
                        ? Branch::find($this->branchId)?->name ?? 'All Branches'
                        : 'All Branches'
                )
                ->icon('heroicon-m-building-office')
                ->form([
                    Select::make('branchId')
                        ->label('Branch')
                        ->options(Branch::pluck('name', 'id'))
                        ->placeholder('All Branches')
                        ->default($this->branchId),
                ])
                ->action(function (array $data): void {
                    $this->branchId = $data['branchId'] ?? null;
                }),
        ];
    }

    protected function getData(): array
    {
        match ($this->filter) {
            'today' => $data = $this->getTodayData(),
            'week'  => $data = $this->getWeekData(),
            'month' => $data = $this->getMonthData(),
            'year'  => $data = $this->getYearData(),
            default => $data = $this->getWeekData(),
        };

        return [
            'datasets' => [
                [
                    'label'           => 'Total Sales (₱)',
                    'data'            => $data['amounts'],
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function baseQuery()
    {
        $query = Sale::query();

        if ($this->branchId) {
            $query->where('branch_id', $this->branchId);
        }

        return $query;
    }

    protected function getTodayData(): array
    {
        $sales = $this->baseQuery()
            ->whereDate('sale_date', Carbon::today())
            ->selectRaw('HOUR(sale_date) as hour, SUM(total_amount) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $labels = [];
        $amounts = [];

        for ($i = 0; $i < 24; $i++) {
            $labels[] = Carbon::today()->setHour($i)->format('h A');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return compact('labels', 'amounts');
    }

    protected function getWeekData(): array
    {
        $query = $this->baseQuery();
        $dates = collect(range(6, 0))->map(fn($i) => Carbon::now()->subDays($i));

        $amounts = $dates->map(function ($date) use ($query) {
            return (float) (clone $query)
                ->whereDate('sale_date', $date)
                ->sum('total_amount');
        })->toArray();

        $labels = $dates->map(fn($d) => $d->format('M d'))->toArray();

        return compact('labels', 'amounts');
    }

    protected function getMonthData(): array
    {
        $sales = $this->baseQuery()
            ->whereYear('sale_date', Carbon::now()->year)
            ->whereMonth('sale_date', Carbon::now()->month)
            ->selectRaw('DAY(sale_date) as day, SUM(total_amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $amounts = [];
        $daysInMonth = Carbon::now()->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = Carbon::now()->day($i)->format('M d');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return compact('labels', 'amounts');
    }

    protected function getYearData(): array
    {
        $sales = $this->baseQuery()
            ->whereYear('sale_date', Carbon::now()->year)
            ->selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $amounts = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $amounts[] = isset($sales[$i]) ? (float) $sales[$i]->total : 0;
        }

        return compact('labels', 'amounts');
    }

    protected function getType(): string
    {
        return 'line';
    }
}
