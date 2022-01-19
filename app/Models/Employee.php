<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $hidden = ['pivot'];
    
    use HasFactory;
    protected $fillable = [
        'name', 'limit', 'description'
    ];

    protected $table = 'empleado';
    public $timestamps = false;


    public function roles()
    {
        return $this->belongsToMany(Role::class,  'empleado_rol', 'empleado_id', 'rol_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
