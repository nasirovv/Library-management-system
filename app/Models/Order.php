<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'wantedDate',
        'wantedDuration',
        'status_id',
        'librarian_id',
        'givenDate',
        'mustReturnDate',
        'returnedDate'
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function librarian(){
        return $this->belongsTo(Librarian::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function comment(){
        return $this->hasOne(Comment::class);
    }


}
