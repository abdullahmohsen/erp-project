<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    // use HasFactory;
    use Translatable;

    protected $guarded = ['id'];

    public $translatedAttributes = ['name', 'description'];

    protected $appends = ['image_path', 'profit_percent'];

    public function getImagePathAttribute()
    {
        return asset('uploads/product_images/'.$this->image);
    }//end of get image path

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent, 2); //number_format() take how many digit numbers in secound parameter
    }//end of get profit attribute

    public function category()
    {
        return $this->belongsTo(Category::class);
    }//end fo category
}//end of model
