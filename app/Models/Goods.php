<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;
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
        'unit_weight',
        'unit_gross_weight',
        'description'
    ];

    /**
     * Set unit weight date.
     *
     * @param $weight
     */
    public function setUnitWeightAttribute($weight)
    {
        $this->attributes['unit_weight'] = extract_number($weight);
    }

    /**
     * Set unit gross weight date.
     *
     * @param $weight
     */
    public function setUnitGrossWeightAttribute($weight)
    {
        $this->attributes['unit_gross_weight'] = extract_number($weight);
    }
}
