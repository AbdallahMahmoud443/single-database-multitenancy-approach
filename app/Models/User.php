<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Scopes\TenantScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


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
        'tenant_id'
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
    /**
     * Get the tenant that the user belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return Tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    /**
     * Get the scope for tenant users.
     */
    public function scopeTenantUser($query)
    {
        return $query->where('tenant_id', Auth::user()->tenant_id);
    }

    protected static function booted()
    {
        // hint: defined Global Scope for Tenant
        // important: should check first if user is logged in,then fetch All User based on where clause in TenantScope class (Trick),
        // important: should TenantScope doesn't work when fetch Auth User , so we need to check if user is logged in (Trick)
        if (Auth::check())  static::addGlobalScope(new TenantScope);
    }
}
