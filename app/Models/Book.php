<?php

namespace App\Models;

use App\Facades\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'ISBN',
        'description',
        'originalCount',
        'count',
        'image',
        'publishedDate'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function getImageAttribute()
    {
        $default = url('/') . '/images/book-default.jpg';
        return Image::get('books', $this->attributes['id']) ?? $default;
    }

}
