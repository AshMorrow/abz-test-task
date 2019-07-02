<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = "employees";

    protected $fillable = [
        'name',
        'phone',
        'email',
        'salary',
        'position_id',
        'head_id',
        'employment_date'
    ];

    public function position() {
        return $this->hasOne('App\Position');
    }

    public function head() {
        return \App\Employees::find($this->head_id);
    }

    public function getConvertedEmploymentDate() {
        return date('d.m.y', strtotime($this->employment_date));
    }
}
