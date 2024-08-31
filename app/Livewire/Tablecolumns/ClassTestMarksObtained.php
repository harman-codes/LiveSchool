<?php

namespace App\Livewire\Tablecolumns;

use App\Helpers\Notify;
use App\Models\Classtest;
use Livewire\Component;

class ClassTestMarksObtained extends Component
{
    /*Set from table*/
    public $record;
    public $classtestid;

    /*Custom Properties*/
    public $marksobtained;
    public $is_buttonDisabled = false;

    public function updatedMarksobtained()
    {
        if(!empty($this->classtestid)&&!empty($this->record->id)){
            $is_updated = Classtest::where('id', $this->classtestid)->update(['marksobtained->'.$this->record->id => $this->marksobtained]);
            if($is_updated){
                Notify::success('Marks Updated for '.$this->record->name);
            }
        }
    }


    public function render()
    {
        if(!empty($this->classtestid)&&!empty($this->record->id)){
            $this->marksobtained = Classtest::where([
                ['id', '=', $this->classtestid],
                ['marksobtained->'.$this->record->id, '!=', null]
            ])?->first()?->marksobtained[$this->record->id];
            $this->is_buttonDisabled = false;
        }else{
            $this->is_buttonDisabled = true;
        }
        return view('livewire.tablecolumns.class-test-marks-obtained');
    }
}
