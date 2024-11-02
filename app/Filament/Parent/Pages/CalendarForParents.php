<?php

namespace App\Filament\Parent\Pages;

use Filament\Pages\Page;

class CalendarForParents extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.parent.pages.calendar-for-parents';

    protected static ?string $title = 'Calendar';

    protected static ?int $navigationSort = 3;
}
