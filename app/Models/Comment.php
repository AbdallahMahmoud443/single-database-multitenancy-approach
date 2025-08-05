<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Tenantable;

class Comment extends Model
{
    //
    // hint: defined trait to apply on this class
    use Tenantable;
    protected $guarded = ['id'];
}
