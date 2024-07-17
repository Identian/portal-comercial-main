<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTimeFormatLinkage extends Model
{

    protected $visible = [
        'id',
        'name',
        'active',
    ];
    protected $fillable = [
        'id',
        'name',
        'active',
    ];

    public static function getTimeFormatList(){

        $collection = collect([
            ['id' => 1, 'descripcion' => '1 AÑO'],
            ['id' => 2, 'descripcion' => '2 AÑOS'],
        ]);

        return $collection->pluck('descripcion','id');

        //return self::where('active',1)->orderBy("name","ASC")->pluck('name','id');
    }

}
