<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['waste_bank_id', 'master_name', 'no_customer', 'pickup_status_id', 'name', 'email', 'role', 'quotes', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'current_team_id', 'profile_photo_path', 'phone', 'address', 'created_at', 'updated_at','latitude','longitude'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Search query in multiple whereOr
     */
    public static function search($query,$id)
    {
        return empty($query) ? static::query()->whereWasteBankId($id)
            : static::whereWasteBankId($id)->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhereHas('pickupStatus', function ($q) use ($query) {
                        $q->where('title', 'like', '%' . $query . '%');
                    })->orWhereHas('wasteBank', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
    }

    /**
     * @return BelongsTo
     */
    public function pickupStatus()
    {
        return $this->belongsTo('App\Models\PickupStatus');
    }

    /**
     * @return BelongsTo
     */
    public function wasteBank()
    {
        return $this->belongsTo('App\Models\WasteBank');
    }

    /**
     * @return HasMany
     */
    public function presences()
    {
        return $this->hasMany('App\Models\Presence');
    }

    /**
     * @return HasMany
     */
    public function wasteDeposits()
    {
        return $this->hasMany('App\Models\WasteDeposit');
    }

}

