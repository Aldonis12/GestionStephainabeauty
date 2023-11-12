<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDetails extends Model
{
    protected $table = 'clientdetails';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idclient','idemploye','idservice','idsalon','prix','inserted'];

    public function Client(){
        return $this->belongsTo(Client::class, 'idclient');
    }

    public function Employe(){
        return $this->belongsTo(Employe::class, 'idemploye');
    }

    public function Service(){
        return $this->belongsTo(Service::class, 'idservice');
    }

    public function Salon(){
        return $this->belongsTo(Salon::class, 'idsalon');
    }
}
