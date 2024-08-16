<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolclassResource\Pages;
use App\Filament\Resources\SchoolclassResource\RelationManagers;
use App\Helpers\Notify;
use App\Models\Schoolclass;
use App\Models\Section;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SchoolclassResource extends Resource
{
    protected static ?string $model = Schoolclass::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Classes & Sections';

    protected static ?string $label = 'Classes';
    protected static ?int $navigationSort = 2;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Class Name')
                    ->required()
                    ->afterStateUpdated(function(Forms\Set $set, Forms\Get $get, ?string $state){
                        if($get('section')!=null){
                            $set('classwithsection', $state.' ('.$get('section').')');
                        }else{
                            $set('classwithsection', null);
                        }
                    })
                    ->live(onBlur: true),
                Forms\Components\Select::make('section')
                    ->options(function(){
                        return Section::all()->pluck('name', 'name');
                    })
                    ->afterStateUpdated(function(Forms\Set $set, Forms\Get $get, ?string $state){
                        if($get('name')!=null){
                            $set('classwithsection', $get('name').' ('.$state.')');
                        }else{
                            $set('classwithsection', null);
                        }
                    })
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('classwithsection')
                    ->label('Class (Section) - [Auto Filled]')
                    ->unique(ignoreRecord: true)
                    ->readOnly()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->reorderRecordsTriggerAction(
                fn (Tables\Actions\Action $action, bool $isReordering) => $action
                    ->button()
                    ->label($isReordering ? 'Disable reordering' : 'Enable reordering'),
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('section'),
                Tables\Columns\TextColumn::make('classwithsection')
                ->label('Class (Section)')
                ->searchable(),
                Tables\Columns\TextColumn::make('subjects.name')
                ->label('Subjects')
                ->badge(),
            ])
            ->defaultSort('sort', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('assignsubjects')
                ->icon('heroicon-o-document-plus')
                ->label('')
                ->color('success')
                ->form(function(){
                    return [
                        Forms\Components\Select::make('subjects')
                            ->label('Assign Subjects')
                            ->multiple()
                            //->relationship('subjects','name')
                            ->options(Subject::all()->pluck('name','id'))
                            ->preload()
                            ->required(),
                    ];
                })
                ->action(function(array $data, Schoolclass $record) {
                    $ifSubjectsAttached = $record->subjects()->syncWithoutDetaching($data['subjects']);

                    if($ifSubjectsAttached){
                        Notify::success('Subjects assigned successfully');
                    }
                }),
                Tables\Actions\Action::make('detachsubjects')
                    ->icon('heroicon-o-document-minus')
                    ->label('')
                    ->color('danger')
                    ->form(function(Schoolclass $record) {
                        return [
                            Forms\Components\Select::make('subjects')
                                ->label('Detach Subjects')
                                ->multiple()
                                    ->options($record->subjects()->pluck('name','subject_id'))
                                ->preload()
                                ->required(),
                        ];
                    })
                    ->action(function(array $data, Schoolclass $record) {
                        $ifSubjectsDetached = $record->subjects()->detach($data['subjects']);
                        if ($ifSubjectsDetached) {
                            Notify::success('Subjects removed successfully');
                        }
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('assignsubjectsbulk')
                        ->label('Assign Subjects')
                        ->icon('heroicon-o-document-plus')
                        ->color('success')
                    ->form(function(){
                            return [
                                Forms\Components\Select::make('subjects')
                                    ->label('Select subjects to assign')
                                    ->multiple()
                                    //->relationship('subjects','name')
                                    ->options(Subject::all()->pluck('name','id'))
                                    ->preload()
                                    ->required(),
                            ];
                        })
                        ->action(function(array $data, Collection $record) {
                            $ifSubjectsAttached = $record->each(function ($instance) use ($data) {
                                $instance->subjects()->syncWithoutDetaching($data['subjects']);
                            });
                            if($ifSubjectsAttached){
                                Notify::success('Subjects assigned successfully');
                            }
                        }),
                    Tables\Actions\BulkAction::make('removesubjectsbulk')
                        ->label('Remove Subjects')
                        ->icon('heroicon-o-document-minus')
                        ->color('danger')
                        ->form(function(){
                            return [
                                Forms\Components\Select::make('subjects')
                                    ->label('Select subjects to remove')
                                    ->multiple()
                                    //->relationship('subjects','name')
                                    ->options(Subject::all()->pluck('name','id'))
                                    ->preload()
                                    ->required(),
                            ];
                        })
                        ->action(function(array $data, Collection $record) {
                            $ifSubjectsAttached = $record->each(function ($instance) use ($data) {
                                $instance->subjects()->detach($data['subjects']);
                            });
                            if($ifSubjectsAttached){
                                Notify::success('Subjects removed successfully');
                            }
                        }),

                ]), //bulk action group
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
            'index' => Pages\ListSchoolclasses::route('/'),
            'create' => Pages\CreateSchoolclass::route('/create'),
            'edit' => Pages\EditSchoolclass::route('/{record}/edit'),
        ];
    }
}
