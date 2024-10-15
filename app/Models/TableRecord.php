<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableRecord extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'data_table_id',
        'month',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function dataTable()
    {
        return $this->belongsTo(DataTable::class);
    }
}