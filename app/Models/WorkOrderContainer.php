<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderContainer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['container_id', 'is_empty', 'seal', 'description'];

    /**
     * Get the work order of the container.
     */
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /**
     * Get the container of the work order containers.
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
