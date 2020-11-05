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

    public $translatedAttributes = ['name'];
    // public $translatable = ['name'];

    protected $guarded = [];
    // protected $fillable = ['parent_id', 'slug', 'is_active'];
    // protected $hidden = ['translations'];
    // protected $with = ['translations'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }

    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }

    public function getActive(){
        return $this -> is_active == 0 ? __('site.notactive') : __('site.active');
    }

    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function _child(){
        return $this->hasMany(self::class, 'parent_id');
    }
}//end of model
