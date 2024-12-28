<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\CurrentUser;
use Filament\Pages\Page;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class TimeTable extends Page implements HasTable
{

    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.parent.pages.time-table';

    protected static ?int $navigationSort = 8;

    public function boot()
    {
        return Group::configureUsing(function(Group $group) {
            return $group
                ->titlePrefixedWithLabel(false);
        });
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(function () {
                return \App\Models\TimeTable::where('schoolclass_id', CurrentUser::classId());
            })
            ->defaultGroup('timetableslot.title')
            ->columns([
                TextColumn::make('timetableslot.title')
                    ->label('Day'),
                TextColumn::make('from')
                    ->sortable()
                ->badge(),
                TextColumn::make('to')
                ->badge(),
                TextColumn::make('subject'),
                TextColumn::make('remarks'),
            ]);
    }


}
