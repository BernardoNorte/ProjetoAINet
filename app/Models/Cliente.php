<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cliente extends Model
{

    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['id','nif', 'address', 'payment_type','payment_ref'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

}
