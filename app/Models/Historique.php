<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;
    //ManyToOne with module
    public function module() {
        return $this->belongsTo(Module::class);
    }
}
