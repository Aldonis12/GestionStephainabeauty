<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeService extends Model
{
    protected $table = 'employeservice';
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idemploye','idservice','idsalon','inserted'];

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
