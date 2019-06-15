<?php

namespace App;

//nesse comando do artisan usa se o -m quando se quer ter uma migration junto, o que implica em comunicação com o banco de dados
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $pk = 'id';
    public function user(){
        return $this->belongsTo('App\User');
    }

}
