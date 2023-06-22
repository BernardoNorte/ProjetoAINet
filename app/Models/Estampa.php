<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estampa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','client_id', 'category_id', 'name','description', 'image_url', 'extra_info'];

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class, 'estampa_id', 'id');
    }

    public function id()
    {
        return $this->HasOne(Estampa::class,'id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'category_id');
    }
}
