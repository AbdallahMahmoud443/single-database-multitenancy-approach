<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PDO;

class Article extends Model
{
    //
    protected $guarded = ['id'];


    /**
     * Get the user that owns the article.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the tenant that owns the article.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    protected static function booted()
    {
        // hint: defined Global Scope for Tenant
        static::addGlobalScope(new TenantScope);

        // hint: this event should be used to set the tenant_id for every model,during creation Process
        static::creating(function (Article $article) {
            $article->tenant_id = Auth::user()->tenant_id;
        }); // Will fire before a new model is saved.
    }
}
