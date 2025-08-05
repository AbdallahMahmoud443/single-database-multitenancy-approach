<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use App\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //
    protected $guarded = ['id'];
    // hint: defined trait to apply on this class
    use Tenantable;
}
