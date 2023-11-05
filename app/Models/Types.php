<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    protected $table = 'types';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom'];
}
