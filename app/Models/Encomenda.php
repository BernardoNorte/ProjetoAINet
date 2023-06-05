<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['status', 'customer_id','date', 'total_price', 'notes', 'nif', 'address','payment_type','payment_ref'];
}
