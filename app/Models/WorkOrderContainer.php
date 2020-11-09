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
}
