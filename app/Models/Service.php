<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['nom','idtypes'];

    public function Types(){
        return $this->belongsTo(Types::class, 'idtypes');
    }
}
