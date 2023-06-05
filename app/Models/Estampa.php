<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estampa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','cliente_id', 'categoria_id', 'nome','descricao', 'imagem_url', 'informacao_extra'];

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class, 'estampa_id', 'id');
    }

}
