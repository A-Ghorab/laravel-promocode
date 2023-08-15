<?php

namespace AGhorab\LaravelPromocode\Models;

use AGhorab\LaravelPromocode\Database\Factories\PromocodeRedemptionFactory;
use function AGhorab\LaravelPromocode\getboundedReedemerModelName;
use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTable;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTablePromocodeIdField;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTableUserIdField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PromocodeRedemption extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): PromocodeRedemptionFactory
    {
        return new PromocodeRedemptionFactory();
    }

    /**
     * @param  array<string,scalar>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(getPromocodeRedemptionTable());
    }

    /**
     * @return BelongsTo<PromocodeRedemption,Promocode>
     */
    public function promocode(): BelongsTo
    {
        return $this->belongsTo(
            getPromocodeModel(),
            getPromocodeRedemptionTablePromocodeIdField(),
        );
    }

    /**
     * @return BelongsTo<PromocodeRedemption,\Illuminate\Foundation\Auth\User>
     */
    public function redeemer(): BelongsTo
    {
        return $this->belongsTo(
            getboundedReedemerModelName(),
            getPromocodeRedemptionTableUserIdField(),
        );
    }

    /**
     * @return MorphTo<Model,PromocodeRedemption>
     */
    public function redeemedItems(): MorphTo
    {
        return $this->morphTo();
    }
}
