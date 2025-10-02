<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminDashboardWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Welcome', 'This is the admin dashboard.'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->role === 'admin';
    }
}
