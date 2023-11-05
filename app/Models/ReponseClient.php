<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReponseClient extends Model
{
    protected $table = 'reponseclient';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idclient','idquestion','reponse','idsalon','inserted'];

    public function Client(){
        return $this->belongsTo(Client::class, 'idclient');
    }

    public function Question(){
        return $this->belongsTo(Question::class, 'idquestion');
    }

    public function Salon(){
        return $this->belongsTo(Salon::class, 'idsalon');
    }
}
