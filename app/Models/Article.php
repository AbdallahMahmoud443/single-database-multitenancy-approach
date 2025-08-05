<?php

namespace App\Models;


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
    /**
     * Get the scope for tenant users.
     */
    public function scopeTenantUser($query)
    {
        return $query->where('tenant_id', Auth::user()->tenant_id);
    }

    protected static function booted()
    {
        // hint: this event should be used to set the tenant_id for every model,during creation Process
        static::creating(function (Article $article) {
            $article->tenant_id = Auth::user()->tenant_id;
        }); // Will fire before a new model is saved.
    }
}
