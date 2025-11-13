<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'artist_id', 'genre_id', 'duration', 'user_id'];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

   
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_track');
    }
}