<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class CalendarioR extends Model
{
    use HasFactory;

    protected $primaryKey = '_id';

    protected $fillable = [
        'descargasRecibidos',
        'erroresRecibidos',
        'fechaDescarga',
        'fechaDescargaF'
    ];

    protected $collection = 'calendario_r';
}
