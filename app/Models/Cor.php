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
    protected $primaryKey = 'codigo';
    public $incrementing = false;

    protected $table = 'cores';
    protected $fillable = ['codigo', 'nome'];

    public function user()
    {
        return $this;
    }
}
