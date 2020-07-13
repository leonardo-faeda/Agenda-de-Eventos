<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacao extends Model
{
    use SoftDeletes;
    protected $fillable = ['mensagem', 'id_user', 'id_evento'];
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function evento(){
        return $this->belongsTo('App\Evento');
    }
}
