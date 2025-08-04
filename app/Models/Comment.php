<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    //




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
}
