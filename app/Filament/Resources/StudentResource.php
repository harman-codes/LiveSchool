<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Filament\Widgets\SessionyearSelectorWidget;
use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\Schoolclass;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationBadgeTooltip = 'Total Students';

    protected static ?string $navigationGroup = 'Students';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return Student::count();
    }

//    public static function getEloquentQuery(): Builder
//    {
//        return parent::getEloquentQuery()->with('studentdetails', function($query) {
//            return $query->where('sessionyear', '2025-26')->with(['schoolclass']);
//        });
//    }


    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(25)
            ->modifyQueryUsing(function(Builder $query) {
                return $query->with('studentdetails', function($query) {
                    return $query->where('sessionyear', SessionYears::currentSessionYear())->with(['schoolclass']);
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admissionno')
                    ->label('Adm No')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mobile')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fathername')
                    ->label('Father\'s Name')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mothername')
                    ->label('Mother\'s Name')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('username')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('studentdetails.sessionyear')
                    ->label('Session')
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('class')
                    ->getStateUsing(function ($record) {
                        return $record->studentdetails()->first()?->schoolclass?->classwithsection;
                    }),
//                Tables\Columns\TextColumn::make('sessionyear')
//                    ->getStateUsing(function ($record) {
//                        return $record->studentdetails()->first()?->sessionyear;
//                    }),
//                Tables\Columns\TextColumn::make('studentdetails.schoolclass.classwithsection')
//                    ->label('Class')
//                    ->listWithLineBreaks()
//                    ->searchable(),
                Tables\Columns\TextColumn::make('studentdetails.rollno')
                    ->label('Roll No')
                    ->listWithLineBreaks(),
            ])
            ->filters([
                //--------Filter--------//
//                Tables\Filters\Filter::make('filtetr')
//                    ->form([
//                        Forms\Components\Select::make('sessionyear')
//                            ->label('Session Year')
//                            ->options(SessionYears::years())
//                    ])
//                    ->query(function (Builder $query, array $data): Builder {
//                        return $query
//                            ->when(
//                                $data['sessionyear'],
//                                fn (Builder $query): Builder => $query->withWhereHas('studentdetails', function($query) use ($data) {
//                                    return $query->where('sessionyear', $data['sessionyear'])->with(['schoolclass']);
//                                }));
//                    }),
//                Tables\Filters\Filter::make('sessionyear')
//                    ->form([
//                        Forms\Components\Select::make('choosesessionyear')
//                        ->label('Session Year')
//                        ->options([
//                            '2024-25' => '2024-25',
//                            '2025-26' => '2025-26',
//                            '2026-27' => '2026-27',
//                        ])
//                        ->default('2024-25')
//                    ])->query(function (Builder $query, array $data): Builder {
//                        return $query->with('studentdetails', function($query) use ($data) {
//                                    return $query->where('sessionyear', '2024-25')->with(['schoolclass']);
//                            });
//                    }),
                //------Filter Ends-----//
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\Action::make('studentdetailsassign')
                    ->label('Assign')
                    ->icon('heroicon-o-plus-circle')
                    ->iconButton()
                    ->color('success')
                    ->form(function ($record) {
                        return [
                            Forms\Components\Select::make('sessionyear')
                                ->label('Current Session')
                                ->options(SessionYears::years())
                                ->default(SessionYears::currentSessionYear())
                                ->disabled()
                                ->dehydrated(),
                            Forms\Components\Select::make('classwithsection')
                                ->label('Class (Section)')
                                ->options(function () {
                                    return Schoolclass::all()->pluck('classwithsection', 'id');
                                })
                                ->default($record->studentdetails()->first()?->schoolclass?->id)
                                ->required(),
                            Forms\Components\TextInput::make('rollno')
                                ->label('Roll No')
                                ->default($record->studentdetails()->first()?->rollno)
                                ->required(),
                        ];
                    })
                    ->action(function (array $data, Student $record) {
                        $updateOrCreateRecord = $record->studentdetails()->updateOrCreate(
                            [
                                'student_id' => $record->id,
//                                'sessionyear' => SessionYears::currentSessionYear(),
                                'sessionyear' => $data['sessionyear']
                            ],
                            [
                                'schoolclass_id' => $data['classwithsection'],
                                'rollno' => $data['rollno'],
                            ]
                        );
                        if ($updateOrCreateRecord) {
                            Notify::success('Saved Successfully');
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /*Section 1*/
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('admissionno')
                            ->label('Admission No'),
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\Select::make('gender')
                            ->options(['m' => 'Male', 'f' => 'Female', 'o' => 'Other'])->required(),
                        Forms\Components\DatePicker::make('dob')
                            ->label('DOB'),
                    ]),

                /*Section 2*/
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('mobile')
                            ->tel(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required(),
                    ]),

                /*Section 3*/
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('fathername')
                            ->label('Father\'s Name'),
                        Forms\Components\TextInput::make('mothername')
                            ->label('Mother\'s Name'),
                        Forms\Components\Textarea::make('address'),
                    ]),

                /*Secction 4*/
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                    ]),

                /*Section 5*/
//                Forms\Components\Section::make()
//                    ->columns([
//                        'sm' => 1,
//                        'md' => 3
//                    ])
//                    ->heading('Optional')
//                    ->description('You can update these options later')
//                    ->schema([
//                        Forms\Components\Select::make('sessionyear')
//                            ->relationship('studentdetails', 'sessionyear')
////                            ->options(SessionYears::years())
//                            ->default(SessionYears::currentSessionYear()),
//                        Forms\Components\Select::make('studentdetails.student_id')
//                            ->label('Class (Section)')
//                            ->relationship('studentdetails', 'schoolclass_id', modifyQueryUsing: fn($query) => $query->orderBy('sort', 'asc'))
//                        ->options(function(){
//                            return Schoolclass::all()->pluck('classwithsection', 'id');
//                        }),
//                            ->options(function () {
//                                return Schoolclass::all()->pluck('classwithsection', 'id');
//                             }),
//                        Forms\Components\TextInput::make('studentdetails.rollno')
//                            ->label('Roll No'),
//                    ]),
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
