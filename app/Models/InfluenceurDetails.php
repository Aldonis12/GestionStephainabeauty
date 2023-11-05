<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluenceurDetails extends Model
{
    protected $table = 'influenceurdetails';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idinfluenceur','idreseauxsociaux','lien','likes','comments','inserted'];

    public function Influenceur(){
        return $this->belongsTo(Influenceur::class, 'idinfluenceur');
    }

    public function Reseau(){
        return $this->belongsTo(ReseauxSociaux::class, 'idreseauxsociaux');
    }

}
