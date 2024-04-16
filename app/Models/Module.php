<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
  
    //OneToMany with historique
    public function historiques() {
        return $this->hasMany(Historique::class);
    } 
}
