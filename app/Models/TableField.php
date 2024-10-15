<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableField extends Model
{
    protected $fillable = ['data_table_id', 'field_name', 'field_type'];

    public function dataTable()
    {
        return $this->belongsTo(DataTable::class);
    }
}
