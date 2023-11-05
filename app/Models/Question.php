<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['question'];
}
