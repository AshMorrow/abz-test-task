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
        'head_id'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'admin_updated_id',
        'admin_created_id',
    ];

    public function position() {
        return $this->hasOne('App\Position');
    }
    public function head()
    {
        return $this->hasOne('App\Employees');
    }
}
