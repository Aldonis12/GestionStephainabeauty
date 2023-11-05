<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluenceurPrestataire extends Model
{
    protected $table = 'influenceurprestataire';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idinfluenceur','idemploye','idservice','idsalon','inserted'];

    public function Influenceur(){
        return $this->belongsTo(Influenceur::class, 'idinfluenceur');
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
