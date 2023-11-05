<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $table = 'salon';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom','adresse'];

}
