<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    /**
     * Получить коллекции пользователя
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    /**
     * Получить статистику для профиля
     */
    public function getStats()
    {
        $tracksCount = $this->tracks()->count();
        $collectionsCount = $this->collections()->count();
        $totalDuration = $this->tracks()->sum('duration');
        $totalHours = round($totalDuration / 3600, 2); // переводим секунды в часы

        return [
            'tracks_count' => $tracksCount,
            'collections_count' => $collectionsCount,
            'total_hours' => $totalHours
        ];
    }
}
