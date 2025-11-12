<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'artist_id', 'genre_id', 'duration', 'user_id'];

    /**
     * Получить пользователя-владельца трека
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить исполнителя трека
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Получить жанр трека
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Получить коллекции, в которых находится трек
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_track');
    }
}