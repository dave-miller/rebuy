<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'options' => 'array',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->setDefaultSettings();
        });
    }

    /**
     * Set the default settings for a user upon creation.
     *
     * @return void
     */
    protected function setDefaultSettings()
    {
        $this->settings = [
            'default' => true,
            'timer_duration' => 30,
        ];
    }

    /**
     * Get the decoded settings attribute.
     *
     * @param  string  $value
     * @return mixed
     */
    public function getSettingsAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Set the encoded settings attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }

    /**
     * hasMany Timers
     *
     * @return void
     */
    public function pomodoros()
    {
        return $this->hasMany(Pomodoro::class);
    }
}
