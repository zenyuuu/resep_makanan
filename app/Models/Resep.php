<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'reseps';
    protected $fillable = ['judul', 'bahan', 'gambar', 'langkah', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'resep_id', 'user_id')->withTimestamps();
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
