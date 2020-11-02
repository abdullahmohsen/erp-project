<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
// use Astrotomic\Translatable\Contracts\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;


class Category extends Model
{
    use Translatable;
    // use HasTranslations;

    protected $guarded = [];
    public $translatedAttributes = ['name'];
    // public $translatable = ['name'];

}//end of model
