<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\UserDashboardWidget::class,
            \App\Filament\Widgets\DospemDashboardWidget::class,
            \App\Filament\Widgets\AdminDashboardWidget::class,
        ];
    }
}
