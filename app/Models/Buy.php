<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    protected $primaryKey = 'compra_id';
    protected $fillable = ['usuario_fk', 'estado'];

    public function products() {
        return $this->belongsToMany(Game::class, 'buy_have_products', 'compra_fk', 'juego_fk', 'compra_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id');
    }
}
