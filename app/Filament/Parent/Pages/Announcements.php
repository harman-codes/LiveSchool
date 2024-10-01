<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\SessionYears;
use App\Models\Student;
use Filament\Pages\Page;

class Announcements extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    protected static string $view = 'filament.parent.pages.announcements';

    public function getAllAnnouncements()
    {
        return Student::where('id', auth('parent')->user()->id)->withWhereHas('studentdetails', function ($query){
            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })?->first()?->studentdetails?->first()?->schoolclass?->announcements()->get();
    }
}
