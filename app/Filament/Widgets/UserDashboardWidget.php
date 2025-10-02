<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserDashboardWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Welcome', 'This is the user dashboard.'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->role === 'user';
    }
}
