<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'whatsapp',
        'is_verified',
    ];

    public function umkm()
    {
        return $this->hasOne(Umkm::class, 'owner_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'owner_id');
    }

    public function isOwner(): bool
    {
        return $this->role === 'OWNER';
    }

    public function isBuyer(): bool
    {
        return $this->role === 'BUYER';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function canBuy(): bool
    {
        return in_array($this->role, ['BUYER', 'OWNER']);
    }

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
        ];
    }
}
