<?php

namespace App\Filament\Pages;

use App\Helpers\DT;
use App\Models\Driver;
use App\Models\MapKey;
use Filament\Pages\Page;

class VanLocation extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static string $view = 'filament.pages.van-location';
    public $selectedVan;
    public $datetime;
    public $location;
    public $switch;
    public $driverName;
    public $vehicleNumber;
    public $dateTime;
    public ?bool $locationStatus;

    public function getVanNumbers()
    {
        return Driver::query()->get(['id', 'van']);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        /*if van is not selected, set default location*/
        if(!empty($this->selectedVan)){
            $data = Driver::where('id', $this->selectedVan)->first();
            $this->location = $data->location;
            $this->driverName = $data->name;
            $this->vehicleNumber = $data->van;
            $this->dateTime = DT::formatDate($data->datetime, 'd-m-Y (h:i:s A)');
            $this->locationStatus = (bool)$data->is_switchon;
        }else{
            $this->location = 'india';
            $this->reset('selectedVan', 'driverName', 'vehicleNumber', 'locationStatus', 'dateTime');
        }

        return parent::render();
    }


}
