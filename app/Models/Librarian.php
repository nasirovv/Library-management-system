<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Librarian extends Model
{
    use HasApiTokens, HasFactory;

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function blockMessages(){
        return $this->hasMany(BlockMessage::class);
    }

}
