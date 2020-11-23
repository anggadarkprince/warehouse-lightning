<?php

namespace App\Models;

use App\Traits\Search\BasicFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory, BasicFilter, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'customer_name',
        'customer_number',
        'pic_name',
        'contact_address',
        'contact_phone',
        'contact_email',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'customer_name' => $this->customer_name,
            'pic_name' => $this->pic_name,
            'contact_email' => $this->contact_email,
        ];
    }
}
