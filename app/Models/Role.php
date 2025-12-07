<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\Role as LaratrustRole;

#[ScopedBy([TenantScope::class])]
class Role extends LaratrustRole
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'display_name',
        'description',
    ];

    /**
     * Users that have this role. Pivot `role_user` includes `organization_id`.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withPivot('organization_id')
            ->withTimestamps();
    }

    /**
     * Permissions attached to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->withTimestamps();
    }
}
