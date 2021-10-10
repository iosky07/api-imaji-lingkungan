<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $waste_deposit_id
 * @property integer $waste_type_id
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 * @property WasteDeposit $wasteDeposit
 * @property WasteType $wasteType
 */
class WasteDepositDetail extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['waste_deposit_id', 'waste_type_id', 'amount','price', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wasteDeposit()
    {
        return $this->belongsTo('App\Models\WasteDeposit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wasteType()
    {
        return $this->belongsTo('App\Models\WasteType');
    }
}
