<?php

namespace App\Observers;

use App\Position;

class PositionObserver
{
    public function creating(Position $position)
    {
        $admin_id = auth()->user()->id;
        $position->admin_created_id = $admin_id;
        $position->admin_updated_id = $admin_id;
    }

    public function updating(Position $position)
    {
        $position->admin_updated_id = auth()->user()->id;
    }
}
