<?php

namespace App\Models;

use App\Models\Search\BasicFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, BasicFilter, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'container_number',
        'shipping_line',
        'container_type',
        'container_size',
        'description'
    ];
}
