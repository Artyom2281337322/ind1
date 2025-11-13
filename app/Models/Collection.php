<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'collection_track')
                    ->withTimestamps();
    }

    
    public function getTracksCountAttribute()
    {
        return $this->tracks()->count();
    }
}