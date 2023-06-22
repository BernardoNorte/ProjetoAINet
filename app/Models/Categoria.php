<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id','nome'];

    public function tshirt_images(): HasMany
    {
        return $this->hasMany(Tshirt::class, 'id', 'category_id');
    }

    public function estampas()
{
    return $this->hasMany(Estampa::class, 'category_id');
}

}
