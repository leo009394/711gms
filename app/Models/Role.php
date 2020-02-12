<?php

namespace App\Models;

class Role extends BaseModel
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
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
