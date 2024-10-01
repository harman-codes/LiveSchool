<?php

namespace App\Filament\Parent\Pages;

use Filament\Pages\Page;

class AttendanceForParents extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.parent.pages.attendance-for-parents';

    protected static ?string $navigationLabel = 'Attendance';

    protected static ?string $title = 'Attendance';
}
