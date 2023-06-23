<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cor extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $primaryKey = 'code';
    public $incrementing = false;

    protected $table = 'cores';
    protected $fillable = ['code', 'name'];

    public function user()
    {
        return $this;
    }

    public function tshirts(): HasMany
    {
        return $this->hasMany(Tshirt::class, 'id', 'code');
    }
}
