<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tshirt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['encomenda_id', 'estampa_id', 'cor_codigo','tamanho', 'quantidade', 'preco_un', 'subtotal'];

    public function estampa()
    {
        return $this->belongsTo(Estampa::class,'estampa_id','id');
    }

    public function categorias(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id', 'category_id');
    }

    public function clientes(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id','customer_id');
    }

}
