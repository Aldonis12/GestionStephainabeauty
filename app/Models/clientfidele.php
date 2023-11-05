<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientfidele extends Model
{
    protected $table = 'v_listclientfidele';
    
    public $timestamps = false;
    
    protected $fillable = ['idclient','mois','annee','visite'];

    public function Client(){
        return $this->belongsTo(Client::class, 'idclient');
    }
}
