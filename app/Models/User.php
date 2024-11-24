<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use function array_merge;
use function fake;
use function str_ends_with;

class User extends Authenticatable implements HasMedia
{
    use InteractsWithMedia;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ANON_EMAIL_SUFFIX = "@anon.net";
    public const MAX_MEDIA_SIZE_KB = 500 * 1024;
    public const MAX_MEDIA_COUNT = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        ];
    }

    public function texts(): HasMany
    {
        return $this->hasMany(Text::class);
    }

    public static function makeAnonymous(array $attributes = []): User
    {
        $anonId = fake()->regexify('[A-Z0-9]{3}\-[A-Z1-9]{3}');

        return self::make(array_merge($attributes, [
            'email' => $anonId . self::ANON_EMAIL_SUFFIX,
            'password' => Hash::make(Str::random(32)),
        ]));
    }

    public static function createAnonymous(array $attributes = []): User
    {
        $user = self::makeAnonymous($attributes);
        $user->save();

        return $user;
    }

    public function isAnonymous(): bool
    {
        return str_ends_with($this->email, self::ANON_EMAIL_SUFFIX);
    }

    public function scopeAnonymous(Builder $query): Builder
    {
        return $query->where('email', 'LIKE', '%' . self::ANON_EMAIL_SUFFIX);
    }

    public function anonTokens(): HasMany
    {
        return $this->hasMany(AnonUserToken::class);
    }
}
