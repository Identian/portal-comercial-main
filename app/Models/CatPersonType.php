<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPersonType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'descripcion',
    ];

    public static function getPersonTipeList(){

    return self::whereNotNull('id')->pluck('descripcion','id');
    }

}
