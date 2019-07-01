<?php

namespace App\Observers;

use App\Employees;

class EmployeeObserver
{
    /**
     * Handle the employees "created" event.
     *
     * @param  \App\Employees  $employees
     * @return void
     */
    public function created(Employees $employees)
    {
        //
    }

    /**
     * Handle the employees "updated" event.
     *
     * @param  \App\Employees  $employees
     * @return void
     */
    public function updated(Employees $employees)
    {
        //
    }

    /**
     * Handle the employees "deleted" event.
     *
     * @param  \App\Employees  $employees
     * @return void
     */
    public function deleted(Employees $employees)
    {
        //
    }

    /**
     * Handle the employees "restored" event.
     *
     * @param  \App\Employees  $employees
     * @return void
     */
    public function restored(Employees $employees)
    {
        //
    }

    /**
     * Handle the employees "force deleted" event.
     *
     * @param  \App\Employees  $employees
     * @return void
     */
    public function forceDeleted(Employees $employees)
    {
        //
    }
}
