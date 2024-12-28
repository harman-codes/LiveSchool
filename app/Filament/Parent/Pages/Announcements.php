<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\SessionYears;
use Filament\Pages\Page;
use Livewire\WithPagination;

class Announcements extends Page
{
    use WithPagination;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    protected static string $view = 'filament.parent.pages.announcements';

    protected static ?int $navigationSort = 4;

    public function getAllAnnouncements()
    {
        return auth('parent')->user()->withWhereHas('studentdetails', function ($query) {
            $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
        })->first()?->studentdetails?->first()?->schoolclass?->announcements()->where('is_published', true)?->paginate(10);
    }
}
