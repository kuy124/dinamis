<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataTable extends Model
{
    protected $fillable = ['table_name', 'description'];

    public function fields()
    {
        return $this->hasMany(TableField::class);
    }

    public function records()
    {
        return $this->hasMany(TableRecord::class);
    }
}