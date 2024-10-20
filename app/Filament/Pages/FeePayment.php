<?php

namespace App\Filament\Pages;

use App\Helpers\Notify;
use App\Helpers\SessionYears;
use App\Models\FeeStructure;
use App\Models\Schoolclass;
use App\Models\Student;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class FeePayment extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.fee-payment';

    protected static ?string $navigationGroup = 'Fee Management';

    protected static ?int $navigationSort = 2;

    /*Custom Properties*/
    public $selectedClass = null;
    public $selectedFeeStructure = null;
    public $feePaymentModel = null;


    public function updatedSelectedClass()
    {
        $this->reset('selectedFeeStructure');
    }

    public function getAllClasses()
    {
        return Schoolclass::all();
    }

    public function getFeeStructure()
    {
        if(!empty($this->selectedClass)){
            return Schoolclass::where('id', $this->selectedClass)->first()?->feeStructures?->where('sessionyear', SessionYears::currentSessionYear());
        }else{
            return null;
        }
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(function(){

                if(!empty($this->selectedClass)&&!empty($this->selectedFeeStructure)){
                    $this->feePaymentModel = \App\Models\FeePayment::where([['sessionyear', SessionYears::currentSessionYear()],['fee_structure_id', $this->selectedFeeStructure]])->get();
                }else{
                    $this->feePaymentModel = null;
                }


                return Student::withWhereHas('studentdetails', function ($query){
                   return $query->where('sessionyear', SessionYears::currentSessionYear())->withWhereHas('schoolclass', function ($query) {
                       if(!empty($this->selectedClass)){
                           return $query->where('id', $this->selectedClass);
                       }else{
                           //return all classes
                           return $query;
                       }
                   });
                });
            })
            ->columns([
                TextColumn::make('name')
                    ->description(function($record){
                        $rollno = $record->studentdetails?->first()?->rollno ?? '';
                        $class = $record->studentdetails?->first()?->schoolclass?->classwithsection ?? '';
                        return $class.' | '.$rollno;
                    }),
                TextColumn::make('fee')
                    ->getStateUsing(function($record){
//                        return $record->studentdetails?->first()?->schoolclass?->feeStructures?->first()?->amount;
                        if(!empty($this->selectedFeeStructure)){
                            return $record->studentdetails?->first()?->schoolclass?->feeStructures?->where('id', $this->selectedFeeStructure)->first()?->amount ?? '';
                        }
                    }),
                TextColumn::make('amountpaid')
                    ->label('Amount Paid')
                    ->getStateUsing(function($record){
                        return $this->feePaymentModel?->where('student_id', $record->id)->first()?->amount_paid ?? '';
                    }),
                TextColumn::make('balance')
                    ->label('Balance')
                    ->getStateUsing(function($record){
                        return $this->feePaymentModel?->where('student_id', $record->id)->first()?->amount_due ?? '';
                    }),
                TextColumn::make('paymentdate')
                    ->label('Payment Date')
                    ->getStateUsing(function($record){
                        return $this->feePaymentModel?->where('student_id', $record->id)->first()?->payment_date ?? '';
                    }),
                TextColumn::make('paymentmode')
                    ->label('Payment Mode')
                    ->getStateUsing(function($record){
                        return $this->feePaymentModel?->where('student_id', $record->id)->first()?->payment_mode ?? '';
                    })
                ->wrap(),
                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->getStateUsing(function($record){
                        return $this->feePaymentModel?->where('student_id', $record->id)->first()?->remarks ?? '';
                    })
                    ->wrap(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('amountpaid')
                ->icon('heroicon-o-plus-circle')
                ->iconButton()
                    ->form(function($record){
                        if(empty($this->selectedClass)||empty($this->selectedFeeStructure)){
                            return [];
                        }

                        $row = \App\Models\FeePayment::where([
                            ['sessionyear', SessionYears::currentSessionYear()],
                            ['student_id', $record->id],
                            ['fee_structure_id', $this->selectedFeeStructure]
                        ])->first();

                        return [
                            TextInput::make('amountpaid')
                            ->label('Amount Paid')
                            ->integer()
                            ->required()
                            ->default($row?->amount_paid),
                            DatePicker::make('paymentdate')
                            ->label('Payment Date')
                            ->required()
                            ->default($row?->payment_date),
                            TextInput::make('paymentmode')
                            ->label('Payment Mode')
                            ->required()
                            ->default($row?->payment_mode),
                            Textarea::make('remarks')
                            ->label('Remarks')
                            ->default($row?->remarks),
                        ];
                    })
                ->action(function(array $data, $record){
                    if(empty($this->selectedClass)||empty($this->selectedFeeStructure)){
                        Notify::fail('Please select fee structure');
                        return '';
                    }

                    $feeAmount = FeeStructure::where('id', $this->selectedFeeStructure)->first()?->amount;

                    $is_recorded = \App\Models\FeePayment::updateOrCreate([
                        'sessionyear' => SessionYears::currentSessionYear(),
                        'student_id' => $record->id,
                        'fee_structure_id' => $this->selectedFeeStructure
                    ],
                        [
                            'amount_paid' => $data['amountpaid'],
                            'amount_due' => $feeAmount-$data['amountpaid'],
                            'payment_date' => $data['paymentdate'],
                            'payment_mode' => $data['paymentmode'],
                            'remarks' => $data['remarks']
                        ]);

                    if($is_recorded){
                        Notify::success('Saved Successfully');
                    }
                    return '';
                })
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
