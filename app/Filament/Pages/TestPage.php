<?php

namespace App\Filament\Pages;

use App\Models\Student;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TestPage extends Page implements HasForms, HasTable
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.test-page';

    protected ?string $test = null;

    use InteractsWithTable;
    use InteractsWithForms;


    public function getstudentdetails()
    {
//        return Student::query()->whereHas('studentdetails', function(Builder $query) {
//            $query->where('sessionyear', 2425);
//        })->get();

//        return Student::withWhereHas('studentdetails', function($query){
//            $query->where('sessionyear', '2025-26');
//        })->get();

//        return Student::withWhereHas('studentdetails', function($query){
//            $query->where('sessionyear', '2025-26');
//        })->orWhere(function($query){
//            $query->doesntHave('studentdetails');
//        })->get();

//        return Student::whereHas('studentdetails', function ($query) {
//            $query->where('sessionyear', '=', '2024-25');
//        }, '=', 1)->get();
    }

    public function table(Table $table): Table
    {
        return $table
//            ->modifyQueryUsing(function($query){
//                return $query->withWhereHas('studentdetails', function($query){
//                    $query->where('sessionyear', '2024-25')->with('schoolclass');
//                })->orWhere(function($query){
//                    $query->doesntHave('studentdetails');
//                });
//            })
            ->query(Student::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('studentdetails.rollno'),
//                TextColumn::make('studentdetails.schoolclass.classwithsection'),
//                TextColumn::make('class')
//                    ->label('Class (Section)')
//                    ->state(function ($record) {
//                        return Student::where('id',$record->id)->withWhereHas('studentdetails', function($query){
//                            $query->where('sessionyear', '2024-25');
//                        })->first()?->studentdetails?->first()->schoolclass?->classwithsection;
//                    })
                TextColumn::make('rollno')
                    ->state(function ($record) {
                        if($record->studentdetails->isNotEmpty()&&!empty($this->test)) {
                            return $record->studentdetails->where('sessionyear', '=', $this->test)->first()->rollno;
                        }
//                        return $record->studentdetails?->first()?->schoolclass?->classwithsection;
                    }),
                TextColumn::make('Faltu')
                ->state(function () {
                        return $this->test;
                }),
            ])
            ->filters([
//                SelectFilter::make('res')
//                    ->options([
//                        'draft' => 'Draft',
//                        'reviewing' => 'Reviewing',
//                        'published' => 'Published',
//                    ]),
                Filter::make('test')
                    ->form([
                        Select::make('syear')
                            ->label('Select Year')
                            ->options([
                                '2024-25' => '2024-25',
                                '2025-26' => '2025-26',
                                '2026-27' => '2026-27',
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
//                        info($data);
//                        return $query;
                        $this->test = $data['syear'];
                        return $query->when($data['syear'],function () use($query, $data) {
                                    return $query->withWhereHas('studentdetails', function ($subquery) use ($data) {
                                        info($data['syear']);
                                        $subquery->where('sessionyear', $data['syear']);
                                    });
                                },
                            );
                    })
            ], layout: FiltersLayout::AboveContent )
            ->actions([
                Action::make('test')
                ->action(function ($record) {
                    info($record);
//                    dd($record);
                })
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
