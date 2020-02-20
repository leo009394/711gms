<?php

namespace App\Models;

class Permission extends BaseModel
{
    /** @var array */
    protected $fillable = [
        'name',
        'slug'
    ];

    /** @var array */
    protected $hidden = [
        'id',
        'pivot'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
