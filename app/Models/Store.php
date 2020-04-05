<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'uuid',
        'phone',
        'address',
        'closing_date',
        'owner_id',
        'manager_id',
        'in_charger_id',
        'active',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function managerUser()
    {
        return $this->hasOne(User::class, 'id','manager_id');
    }

    public function ownerUser()
    {
        return $this->hasOne(User::class, 'id','owner_id');
    }

    public function inChargerUser()
    {
        return $this->hasOne(User::class, 'id','in_charger_id');
    }
}
