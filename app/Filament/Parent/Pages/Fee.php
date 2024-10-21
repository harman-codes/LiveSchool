<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\SessionYears;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Fee extends Page implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.parent.pages.fee';


    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
//                return Student::where('id', auth('parent')->user()->id);
                return FeePayment::where([
                    ['student_id', auth('parent')->user()->id],
                    ['sessionyear', SessionYears::currentSessionYear()],
                ]);
            })
            ->columns([
                TextColumn::make('period')
                    ->label('Period')
                    ->getStateUsing(function($record){
                        $data = FeeStructure::where('id', $record->fee_structure_id)->first();
                        return $data?->from .' - '.$data?->to;
                    }),
                TextColumn::make('fee')
                ->getStateUsing(fn($record) => FeeStructure::where('id', $record->fee_structure_id)->first()?->amount),
                TextColumn::make('amount_paid'),
                TextColumn::make('amount_due'),
                TextColumn::make('payment_date'),
                TextColumn::make('payment_mode'),
                TextColumn::make('remarks')
                ->wrap(),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
