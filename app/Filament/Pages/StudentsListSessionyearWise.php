<?php

namespace App\Filament\Pages;

use App\Helpers\SessionYears;
use App\Models\Student;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentsListSessionyearWise extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-backward';

    protected static string $view = 'filament.pages.students-list-sessionyear-wise';

    protected static ?string $title = 'Students';
    protected static ?string $navigationLabel = 'Prev Years';

    protected static ?string $navigationGroup = 'Students';

    protected static ?int $navigationSort = 2;

    public $currentSessionYear = null;
    public $selectedSessionYear = null;

    public function mount()
    {
        $sessionyear = SessionYears::currentSessionYear();
        $this->currentSessionYear = $sessionyear;
        $this->selectedSessionYear = $sessionyear;
    }


    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No Students')
            ->emptyStateDescription('Please select session year to display the list of students.')
            ->query(function () {
                if (!empty($this->selectedSessionYear)) {
                    return Student::query()->withWhereHas('studentdetails', function ($query) {
                        $query->where('sessionyear', $this->selectedSessionYear)->with(['schoolclass']);
                    });
                } else {
                    return Student::query()->whereNull('id');
                }
            })
            ->columns([
                TextColumn::make('name')
                ->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('admissionno')
                    ->label('Adm No')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mobile')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fathername')
                    ->label('Father\'s Name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mothername')
                    ->label('Mother\'s Name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('address')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('username')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('studentdetails.sessionyear')
                    ->label('Session'),
                TextColumn::make('class')
                    ->state(function ($record) {
                        return $record->studentdetails->first()?->schoolclass->classwithsection;
                    }),
                TextColumn::make('studentdetails.rollno')
                    ->label('Roll No'),
            ])
            ->filters([
                SelectFilter::make('selectClass')
                    ->relationship('studentdetails.schoolclass', 'classwithsection', modifyQueryUsing: fn($query) => $query->orderBy('sort', 'asc'))
                    ->searchable()
                    ->preload()
            ], FiltersLayout::AboveContent);
    }


}
