<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\SessionYears;
use App\Models\Announcement;
use Filament\Pages\Page;

class SchoolAnnouncements extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static string $view = 'filament.parent.pages.school-announcements';

    protected static ?string $title = 'School Notice Board';

    protected static ?int $navigationSort = 10;

    public function getAllAnnouncements()
    {
        return Announcement::query()->where([
            ['sessionyear', SessionYears::currentSessionYear()],
            ['is_published', true],
            ['is_forschool', true],
        ])->paginate(10);
    }
}
