<?php

namespace App\Observers;

use App\Helpers\Notify;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementObserver
{
    /**
     * Handle the Announcement "created" event.
     */
    public function created(Announcement $announcement): void
    {
        //
    }

    /**
     * Handle the Announcement "updated" event.
     */
    public function updated(Announcement $announcement): void
    {
        if($announcement->isDirty('pics')){
            $oldPicsArrayFromDB = $announcement->getOriginal('pics');

            if(!empty($oldPicsArrayFromDB)){

                if(!empty($announcement->pics)){
                    $DeletedPicsFromDB_Array=array_diff($oldPicsArrayFromDB,$announcement->pics);
                }else{
                    $DeletedPicsFromDB_Array=$oldPicsArrayFromDB;
                }


                foreach($DeletedPicsFromDB_Array as $deletedPicFromDB){
                    //delete from storage
                    Storage::disk('public')->delete($deletedPicFromDB);
                }
            }
        }
    }

    /**
     * Handle the Announcement "deleted" event.
     */
    public function deleted(Announcement $announcement): void
    {
        $oldPicsArrayFromDB = $announcement->getOriginal('pics');
        if(!empty($oldPicsArrayFromDB)){
            foreach($oldPicsArrayFromDB as $pic){
                Storage::disk('public')->delete($pic);
            }
        }
    }

    /**
     * Handle the Announcement "restored" event.
     */
    public function restored(Announcement $announcement): void
    {
        //
    }

    /**
     * Handle the Announcement "force deleted" event.
     */
    public function forceDeleted(Announcement $announcement): void
    {
        //
    }
}
