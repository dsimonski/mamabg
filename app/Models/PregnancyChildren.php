<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyChildren extends Model
{
    use HasFactory;

    protected $table = 'pregnancy_children';

    public function pregnancy()
    {
        return $this->belongsTo('App\Models\Pregnancy');
    }
}
