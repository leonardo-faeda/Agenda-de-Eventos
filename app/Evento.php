<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;
    protected $fillable = ['titulo', 'descricao', 'conteudo', 'data'];
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function notificacao(){
        return $this->hasMany('App\Notificacao');
    }

}
