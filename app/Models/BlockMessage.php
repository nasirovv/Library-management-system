<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockMessage extends Model
{
    use HasFactory;

    public function librarian(){
        return $this->belongsTo(Librarian::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
