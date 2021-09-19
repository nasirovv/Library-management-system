<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'order_id'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

}
