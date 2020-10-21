<?php

namespace App\Models;

use App\Models\Search\BasicFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, BasicFilter, SoftDeletes;

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
}
