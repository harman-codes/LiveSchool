<?php

namespace App\Filament\Parent\Pages;

use App\Helpers\DT;
use App\Models\Driver;
use Filament\Pages\Page;

class Van extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static string $view = 'filament.parent.pages.van';

    protected static ?string $title = 'Van Location';

    protected static ?int $navigationSort = 4;

    public $selectedVan;
    public $datetime;
    public $location;
    public $switch;
    public $driverName;
    public $vehicleNumber;
    public $dateTime;
    public ?bool $locationStatus;
    public $mylocation;

    public function setMyLocation($loc)
    {
        $this->mylocation = $loc;
    }
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
            $this->location = null;
            $this->reset('selectedVan', 'driverName', 'vehicleNumber', 'locationStatus', 'dateTime');
        }

        return parent::render();
    }

}
