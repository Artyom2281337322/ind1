<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * Получить пользователя-владельца коллекции
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить треки в коллекции
     */
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'collection_track')
                    ->withTimestamps();
    }

    /**
     * Получить количество треков в коллекции
     */
    public function getTracksCountAttribute()
    {
        return $this->tracks()->count();
    }
}