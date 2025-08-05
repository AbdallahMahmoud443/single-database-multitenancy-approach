<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
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

    protected static function booted()
    {
        // hint: defined Global Scope for Tenant
        static::addGlobalScope(new TenantScope);

        // hint: this event should be used to set the tenant_id for every model,during creation Process
        static::creating(function (Comment $model) {
            $model->tenant_id = Auth::user()->tenant_id;
        }); // Will fire before a new model is saved.
    }

}
