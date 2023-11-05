<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employe';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom','prenom','idgenre','iscanceled','isinternship','inserted'];

    public function Genre(){
        return $this->belongsTo(Genre::class, 'idgenre');
    }
}