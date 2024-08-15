<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Schoolclass;
use App\Models\Student;
use App\Models\Studentdetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationBadgeTooltip = 'Total Students';
    public static function getNavigationBadge(): ?string
    {
        return Student::count();
    }


//    public static function getEloquentQuery(): Builder
//    {
//        return Student::whereHas('studentdetails', function (Builder $query) {
//            $query->where('sessionyear', '=', SessionYears::currentSessionYear());
//        });
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('gender')
                    ->options(['m'=>'Male','f'=>'Female' ,'o'=>'Other'])->required(),
                Forms\Components\DatePicker::make('dob'),
                Forms\Components\TextInput::make('mobile'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('fathername')
                ->label('Father\'s Name'),
                Forms\Components\TextInput::make('mothername')
                ->label('Mother\'s Name'),
                Forms\Components\Textarea::make('address'),
                Forms\Components\TextInput::make('username')->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(25)
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('studentdetails.rollno')
                    ->label('Roll No'),
                Tables\Columns\TextColumn::make('studentdetails.schoolclass.classwithsection')
                    ->label('Class')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('studentdetails')
                    ->label('Assign')
                    ->icon('heroicon-o-plus-circle')
                    ->form(function(Student $record){
                        $sessionyear =  $record->studentdetails->where('student_id',$record->id)?->first()?->sessionyear;
                        $schoolclass_id =  $record->studentdetails->where('student_id',$record->id)?->first()?->schoolclass_id;
                        $rollno =  $record->studentdetails->where('student_id',$record->id)?->first()?->rollno;


                        return [
                            Forms\Components\Select::make('sessionyear')
                            ->label('Current Session')
                            ->options(SessionYears::years())
                            ->default(SessionYears::currentSessionYear())
                            ->disabled(),
                            Forms\Components\Select::make('classwithsection')
                                ->label('Class (Section)')
                                ->options(function(){
                                    return Schoolclass::all()->pluck('classwithsection','id');
                                })
                                ->default($schoolclass_id)
                                ->required(),
                            Forms\Components\TextInput::make('rollno')
                                ->label('Roll No')
                                ->default($rollno)
                                ->required(),
                        ];
                    })
                    ->action(function (array $data, Student $record) {
                        $updateOrCreateRecord = $record->studentdetails()->updateOrCreate(
                            [
                                'student_id' => $record->id,
                                'sessionyear' => SessionYears::currentSessionYear(),
//                                'sessionyear' => $data['sessionyear']
                            ],
                            [
                                'schoolclass_id' => $data['classwithsection'],
                                'rollno' => $data['rollno'],
                            ]
                        );
                        if($updateOrCreateRecord){
                            Notify::success('Saved Successfully');
                        }

                    }),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
