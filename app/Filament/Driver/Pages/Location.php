<?php

namespace App\Filament\Driver\Pages;

use App\Helpers\CurrentUser;
use App\Helpers\DT;
use App\Models\Driver;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Location extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static string $view = 'filament.driver.pages.location';

    /*Custom Properties*/
    public $switch;
    public $location;
    public $datetime;

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public function setLocation($loc)
    {
        Driver::where('id', CurrentUser::id())->update([
            'location' => $loc,
            'datetime' => now()
        ]);

        $this->location = $loc;
    }

    public function toggleswitch()
    {
        $chk = Driver::where('id', CurrentUser::id())->update([
            'is_switchon' => !$this->switch,
        ]);
        if($chk){
            $this->switch = !$this->switch;
            $this->dispatch('switch-status')->self();
        }
    }

    public function mount()
    {
        $this->switch = CurrentUser::user()->is_switchon;
        $this->dispatch('switch-status')->self();
    }

    //override the parent render method and manipulate
    public function render(): \Illuminate\Contracts\View\View
    {
        $currentuser = CurrentUser::user();


        if(!empty($currentuser->datetime)){
            $this->datetime = DT::formatDate($currentuser->datetime, 'd-m-Y (h:i:s A)');
        }
//        else{
//            $this->datetime = DT::formatDate(Carbon::now(), 'd-m-Y (h:i:s A)');
//        }

        if(!empty($currentuser->location)){
            $this->location = $currentuser->location;
        }else{
            $this->location = 'india';
        }
        return parent::render();
    }

}
