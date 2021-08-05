<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    use HasFactory;

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function blockMessages(){
        return $this->hasMany(BlockMessage::class);
    }

}
