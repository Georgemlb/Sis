<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['username', 'password', 'account_type', 'created_on', 'created_by', 'updated_on', 'updated_by'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Disable default timestamps in favor of custom audit columns.
     *
     * @var bool
     */
    public $timestamps = false;

    protected static function booted(): void
    {
        static::creating(function (self $user): void {
            $user->created_on ??= now();
            $user->updated_on ??= now();

            if (Auth::check()) {
                $user->created_by ??= Auth::id();
                $user->updated_by ??= Auth::id();
            }
        });

        static::updating(function (self $user): void {
            $user->updated_on = now();

            if (Auth::check()) {
                $user->updated_by = Auth::id();
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_on' => 'datetime',
            'updated_on' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->username;
    }
}
