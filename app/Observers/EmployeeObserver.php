<?php

namespace App\Observers;

use App\Employees;

class EmployeeObserver
{
    public function creating(Employees $employees)
    {
        $admin_id = auth()->user()->id;
        $employees->admin_created_id = $admin_id;
        $employees->admin_updated_id = $admin_id;
    }

    public function updating(Employees $employees)
    {
        $employees->admin_updated_id = auth()->user()->id;
    }

    public function deleted(Employees $employees)
    {
        $newHead = Employees::inRandomOrder()->first();
        Employees::where('head_id', '=', $employees->id)->update(['head_id' => $newHead->id]);
    }
}
