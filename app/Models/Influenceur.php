<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influenceur extends Model
{
    protected $table = 'influenceur';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom','email','code','iscanceled','inserted'];

}
