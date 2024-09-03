<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource\RelationManagers;
use App\Helpers\DT;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Exam;
use App\Models\Schoolclass;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Exams';
    protected static ?string $navigationLabel = 'Exams';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sessionyear')->label('Session')->default(SessionYears::currentSessionYear())
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Select::make('schoolclass_id')
                    ->options(function(){
                        return Schoolclass::all()->pluck('classwithsection', 'id');
                    })
                    ->label('Class')
                    ->required(),
                Forms\Components\DatePicker::make('fromdate')
                ->required(),
                Forms\Components\DatePicker::make('todate')
                ->required(),
                TextInput::make('examname')
                    ->label('Exam Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('examname')
                ->label('Exam Name')
                ->description(function ($record) {
                    return DT::formatDate($record->fromdate).' | '.DT::formatDate($record->todate);
                }),
                Tables\Columns\TextColumn::make('schoolclass.classwithsection')
                ->label('Class'),
                Tables\Columns\TextColumn::make('subjects.name')
                ->badge(),
                Tables\Columns\TextColumn::make('totalmarks')
                    ->label('Total Marks'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('viewmaxmarks')
                    ->icon('heroicon-o-eye')
                    ->label('')
                ->infolist([
                    KeyValueEntry::make('maxmarks')
                        ->label('Maximum Marks')
                        ->keyLabel('Subject')
                        ->valueLabel('Max Marks'),
//                    Section::make('Max Marks')
//                        ->schema(function($record){
//                                return [
//                                    KeyValueEntry::make('maxmarks')
//                                        ->label('Marks')
//                                        ->keyLabel('Subject')
//                                        ->valueLabel('Max Marks')
//                                ];
//                            return [
//                                TextEntry::make('subjects.name')->listWithLineBreaks(),
//                                TextEntry::make('fromdate'),
//                                TextEntry::make('test')->default($record->examname),
//                            ];
//                        })->columns(),
                ]),

                /*Subjects*/
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('assignsubjects')
                        ->icon('heroicon-o-document-plus')
                        ->label('Add')
                        ->color('success')
                        ->form(function(){
                            return [
                                Forms\Components\Select::make('subjects')
                                    ->label('Assign Subjects')
                                    ->multiple()
                                    ->options(Subject::all()->pluck('name','id'))
                                    ->preload()
                                    ->required(),
                            ];
                        })->action(function(array $data, Exam $record) {
                            $ifSubjectsAttached = $record->subjects()->syncWithoutDetaching($data['subjects']);

                            if($ifSubjectsAttached){
                                /*Add these subjects to maxmarks json column*/
                                $subjectsFromDatabase = Exam::where('id', $record->id)->first()?->subjects->pluck('name')->toArray();

                                $zeroArray = array_fill(0, count($subjectsFromDatabase),0);

                                //set 0 as default value
                                $subjectsWithMaxMarks = array_combine($subjectsFromDatabase, $zeroArray);
                                $record->update([
                                    'totalmarks' => 0,
                                    'maxmarks' => $subjectsWithMaxMarks
                                ]);

                                Notify::success('Subjects assigned successfully');
                            }
                        }),

                    /*Remove Subjects*/
                    Tables\Actions\Action::make('detachsubjects')
                        ->icon('heroicon-o-document-minus')
                        ->label('Remove')
                        ->color('danger')
                        ->form(function(Exam $record) {
                            return [
                                Forms\Components\Select::make('subjects')
                                    ->label('Detach Subjects')
                                    ->multiple()
                                    ->options($record->subjects()->pluck('name','subject_id'))
                                    ->preload()
                                    ->required(),
                            ];
                        })
                        ->action(function(array $data, Exam $record) {
                            $ifSubjectsDetached = $record->subjects()->detach($data['subjects']);
                            if ($ifSubjectsDetached) {

                                /*Add these subjects to maxmarks json column*/
                                $subjectsFromDatabase = Exam::where('id', $record->id)->first()?->subjects->pluck('name')->toArray();

                                $zeroArray = array_fill(0, count($subjectsFromDatabase),0);

                                //set 0 as default value
                                $subjectsWithMaxMarks = array_combine($subjectsFromDatabase, $zeroArray);
                                $record->update([
                                    'totalmarks' => 0,
                                    'maxmarks' => $subjectsWithMaxMarks
                                ]);
                                Notify::success('Subjects removed successfully');
                            }
                        }),
                ])
                    ->button()
                    ->label('Subjects'),
                /*Subjects End*/

                /*Max Marks*/
                    Tables\Actions\Action::make('maxmarks')
                        ->icon('heroicon-o-pencil-square')
                        ->label('')
                        ->color('warning')
                        ->form(function(Exam $record) {

                            $subjects = $record->subjects->pluck('name')->toArray();

                            return array_map(function($subject) use($record) {
                                return TextInput::make($subject)
                                    ->label(ucwords($subject))
                                    ->default($record->maxmarks[$subject] ?? 0);
                            }, $subjects);

                        })->action(function(array $data, Exam $record) {
                            $is_recorded = $record->update([
                                'totalmarks' => array_sum(array_values($data)),
                                'maxmarks' => $data
                            ]);

                            if($is_recorded){
                                Notify::success('Max Marks updated successfully');
                            }
                        }),
                /*Max Marks End*/

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}
