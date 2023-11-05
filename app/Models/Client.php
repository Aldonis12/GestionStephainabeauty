<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom','prenom','date_naissance','idgenre','adresse','numero','email','profession','code','inserted'];

    public function Genre(){
        return $this->belongsTo(Genre::class, 'idgenre');
    }
}
