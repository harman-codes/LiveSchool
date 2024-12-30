<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\View\Components\Modal;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function boot()
    {
        Modal::closedByClickingAway(false);
        Section::configureUsing((function (Section $section) {
            return $section
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ]);
        }));

        \Filament\Infolists\Components\Section::configureUsing(function (\Filament\Infolists\Components\Section $section) {
            return $section
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ]);
        });
    }
}
