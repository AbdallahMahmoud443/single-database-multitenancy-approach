<?php

namespace App;

use App\Models\Scopes\TenantScope;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;


trait Tenantable
{


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
        // title : Data Isolation
        // hint: defined Global Scope for Tenant
        static::addGlobalScope(new TenantScope);
        // hint: this event should be used to set the tenant_id for every model,during creation Process
        static::creating(function (Model $model) {
            $model->tenant_id = Auth::user()->tenant_id;
        }); // Will fire before a new model is saved.
    }
}
