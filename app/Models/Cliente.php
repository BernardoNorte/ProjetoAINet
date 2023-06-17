<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{

    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['id','nif', 'address', 'default_payment_type','default_payment_ref'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function encomendas(): HasMany
    {
        return $this->hasMany(Encomenda::class, 'customer_id', 'id');
    }

    public function tshirt_images(): HasMany
    {
        return $this->hasMany(Tshirt::class, 'id', 'customer_id');
    }

}
