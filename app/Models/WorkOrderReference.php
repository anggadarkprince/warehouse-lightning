<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderReference extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['source_type', 'source_id', 'unit_quantity', 'package_quantity'];

    /**
     * Get the owning source model.
     */
    public function source()
    {
        return $this->morphTo(__FUNCTION__, 'source_type', 'source_id');
    }

    /**
     * Get the owning reference model.
     */
    public function reference()
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');
    }
}
