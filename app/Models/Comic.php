<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comic extends Model
{
    use HasFactory;

    use SoftDeletes;

    // ASSEGNA LA TABELLA COMICS
    protected $table = "comics";

    // ASSEGNA I CAMPI MODIFICABILI IN MASSA (MASS ASSIGNEMENT)
    protected $fillable = ['title', 'price', 'series', 'thumb'];
}
