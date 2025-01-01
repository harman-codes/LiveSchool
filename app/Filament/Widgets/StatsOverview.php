<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use App\Models\Book;
use App\Models\Classtest;
use App\Models\Driver;
use App\Models\Student;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Staff', User::count())
                ->description('Unavailable: ' . User::where('is_available', 0)->count())
                ->color('danger'),
            Stat::make('Total Students', Student::count()),
            Stat::make('Class Tests', Classtest::where('date', now()->format('d-m-Y'))->count())
                ->description('Today')
                ->color('success'),
            Stat::make('Books', Book::count())
                ->description('Issued: ' . Book::where([
                        ['issued', '!=', null],
                    ])->sum('issued'))
                ->color('success'),
            Stat::make('Drivers', Driver::count())
                ->description('Location on: ' . Driver::where([
                        ['is_switchon', 1],
                    ])->count())
                ->color('success'),
            Stat::make('Today\'s Announcements', Announcement::whereDay('created_at', now()->day)->count())
                ->description('Not Approved : ' . Announcement::whereDay('created_at', now()->day)->where('is_published', 0)->count())
                ->color('danger'),
        ];
    }

}
