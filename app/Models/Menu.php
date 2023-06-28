<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];

    
    public function submenus(){
        return $this->hasMany(Submenu::class);
    }
}