<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone_number',
        'street',
        'city',
        'state',
        'zip_code',
    ];

    /**
     * Get the order that the address belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
