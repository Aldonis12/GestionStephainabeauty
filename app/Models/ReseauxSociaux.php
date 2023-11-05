<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReseauxSociaux extends Model
{
    protected $table = 'reseauxsociaux';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom'];
}
