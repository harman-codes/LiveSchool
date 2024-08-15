<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolclassResource\Pages;
use App\Filament\Resources\SchoolclassResource\RelationManagers;
use App\Models\Schoolclass;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                ->label('Class (Section)'),
            ])
            ->defaultSort('sort', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSchoolclasses::route('/'),
            'create' => Pages\CreateSchoolclass::route('/create'),
            'edit' => Pages\EditSchoolclass::route('/{record}/edit'),
        ];
    }
}
