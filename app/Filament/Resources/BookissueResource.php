<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookissueResource\Pages;
use App\Filament\Resources\BookissueResource\RelationManagers;
use App\Helpers\Library;
use App\Helpers\Role;
use App\Helpers\SessionYears;
use App\Models\Bookissue;
use App\Models\Schoolclass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookissueResource extends Resource
{
    protected static ?string $model = Bookissue::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-up';

    protected static ?string $navigationGroup = 'Library';

    protected static ?string $navigationLabel = 'Issue Books';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with(['book', 'student', 'student.studentdetails']);
            })
            ->emptyStateHeading('No Book Issued')
            ->recordAction(null)
            ->striped()
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('sessionyear')
                    ->label('Session Year')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rollNo')
                    ->getStateUsing(function ($record) {
                        return $record->student?->studentdetails?->where('sessionyear', $record->sessionyear)->first()?->rollno ?? '';
                    }),
                Tables\Columns\TextColumn::make('class')
                    ->getStateUsing(function ($record) {
                        return $record->student?->studentdetails?->where('sessionyear', $record->sessionyear)->first()?->schoolclass?->classwithsection ?? '';
                    }),
                Tables\Columns\TextColumn::make('issuedate')
                    ->label('Issue Date'),
                Tables\Columns\TextColumn::make('returndate')
                    ->label('Return Date'),
                Tables\Columns\TextColumn::make('returnedon')
                    ->label('Returned On'),
                Tables\Columns\SelectColumn::make('status')
                    ->options(Library::$bookIssueStatus)
                    ->disabled(fn() => !Role::isAdminOrManagementOrPrincipalOrManager() && !Role::isLibrarian()),
                Tables\Columns\TextInputColumn::make('remarks')
                ->disabled(fn() => !Role::isAdminOrManagementOrPrincipalOrManager() && !Role::isLibrarian()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sessionyear')
                    ->label('Session Year')
                    ->options(SessionYears::years())
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Library::$bookIssueStatus),
                Tables\Filters\Filter::make('class')
                    ->form([
                        Forms\Components\Section::make()
                            ->description('Remove other filters first')
                            ->schema([
                                Forms\Components\Select::make('sessionyear')
                                    ->label('Session Year')
                                    ->options(SessionYears::years())
                                    ->default(SessionYears::currentSessionYear()),
                                Forms\Components\Select::make('schoolclass')
                                    ->label('Class')
                                    ->options(Schoolclass::query()->orderBy('sort', 'asc')->pluck('classwithsection', 'id')->toArray())
                                    ->searchable()
                                    ->preload(),
                            ])->columns(1)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['schoolclass'] && $data['sessionyear'], function (Builder $query) use ($data) {
                                return $query->withWhereHas('student', function ($query) use ($data) {
                                    return $query->withWhereHas('studentdetails', function ($query) use ($data) {
                                        //inside studentdetails
                                        $query->where('sessionyear', $data['sessionyear'])->withWhereHas('schoolclass', function ($query) use ($data) {
                                            //inside schoolclass
                                            return $query->where('id', $data['schoolclass']);
                                        });
                                    });
                                });
                            }); //when
                    }) //query
            ])
            ->actions([
                Tables\Actions\Action::make('Details')
                    ->icon('heroicon-s-eye')
                    ->color('success')
                    ->infolist([
                        Section::make()
                            ->schema([
                                TextEntry::make('book.title')
                                    ->label('Book Title'),
                                TextEntry::make('book.bookcategory.name')
                                    ->label('Book Category'),
                                TextEntry::make('book.authors.name')
                                    ->label('Author')
                                    ->badge(),
                            ])->columns([
                                'sm' => 1,
                                'md' => 3
                            ]),

                        Section::make()
                            ->schema([
                                TextEntry::make('student.name')
                                    ->label('Student Name'),
                                TextEntry::make('rollno')
                                    ->label('Roll No')
                                    ->getStateUsing((function ($record) {
                                        return $record->student?->studentdetails?->where('sessionyear', $record->sessionyear)->first()?->rollno ?? '';
                                    })),
                                TextEntry::make('class')
                                    ->getStateUsing(function ($record) {
                                        return $record->student?->studentdetails?->where('sessionyear', $record->sessionyear)->first()?->schoolclass?->classwithsection ?? '';
                                    })
                                    ->badge(),
                            ])->columns([
                                'sm' => 1,
                                'md' => 3
                            ]),

                        Section::make()
                            ->schema([
                                TextEntry::make('issuedate')
                                    ->label('Issue Date'),
                                TextEntry::make('returndate')
                                    ->label('Return Date'),
                                TextEntry::make('returnedon')
                                    ->label('Returned On'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->formatStateUsing(function ($state) {
                                        return Library::$bookIssueStatus[$state];
                                    }),
                            ])->columns([
                                'sm' => 1,
                                'md' => 2
                            ]),
                        Section::make()
                            ->schema([
                                TextEntry::make('remarks')
                                    ->label('Remarks')
                                    ->columnSpanFull(),
                            ])->columns(1)
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
                /*Book section*/
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('book_id')
                            ->relationship('book', 'title', modifyQueryUsing: fn(Builder $query) => $query->where('instock', '>', 0)->orderBy('title', 'asc'))
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('sessionyear')
                            ->label('Session Year')
                            ->options(SessionYears::years())
                            ->default(SessionYears::currentSessionYear())
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('schoolclass_id')
                            ->label('Class')
                            ->options(Schoolclass::query()->orderBy('sort', 'asc')->pluck('classwithsection', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->live()
                            ->dehydrated(false),

                        Forms\Components\Select::make('student_id')
                            ->label('Student Name')
                            ->relationship('student', 'name', modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                                return $query->withWhereHas('studentdetails', function ($query) use ($get) {
                                    //inside studentdetails
                                    return $query->where('sessionyear', $get('sessionyear'))->withWhereHas('schoolclass', function ($query) use ($get) {
                                        //inside schoolclass
                                        return $query->where('id', $get('schoolclass_id'));
                                    });
                                });
                            })
                            ->searchable()
                            ->preload()
                            ->searchPrompt('Search Student')
                            ->noSearchResultsMessage('No results found')
                            ->hint(fn(Forms\Get $get) => empty($get('schoolclass_id')) ? 'Select a class first' : null)
                            ->hintColor('danger')
                            ->disabled(fn(Forms\Get $get) => empty($get('schoolclass_id')))
                            ->required(),
                    ]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('issuedate')
                            ->label('Issue Date')
                            ->required(),
                        Forms\Components\DatePicker::make('returndate')
                            ->label('Return Date'),
                        Forms\Components\DatePicker::make('returnedon')
                            ->label('Returned On'),
                        Forms\Components\Select::make('status')
                            ->options(Library::$bookIssueStatus)
                            ->required(),
                    ]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('remarks')
                            ->columnSpanFull(),
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
            'index' => Pages\ListBookissues::route('/'),
//            'create' => Pages\CreateBookissue::route('/create'),
//            'edit' => Pages\EditBookissue::route('/{record}/edit'),
        ];
    }
}
