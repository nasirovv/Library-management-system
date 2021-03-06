<?php

namespace App\Models;

use App\Facades\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Librarian extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'id',
        'fullName',
        'username',
        'password',
        'image'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function blockMessages(): HasMany
    {
        return $this->hasMany(BlockMessage::class);
    }

    public function getImageAttribute(): string
    {
        $default = url('/') . '/images/librarian-default.jpg';
        return Image::get('librarians', $this->attributes['id']) ?? $default;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
