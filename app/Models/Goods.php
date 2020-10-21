<?php

namespace App\Models;

use App\Models\Search\BasicFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use HasFactory, BasicFilter, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'item_name',
        'item_number',
        'unit_name',
        'package_name',
        'description'
    ];
}
