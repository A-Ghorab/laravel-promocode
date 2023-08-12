<?php

namespace AGhorab\LaravelPromocode\Models;

use AGhorab\LaravelPromocode\Database\Factories\PromocodeUsageFactory;
use function AGhorab\LaravelPromocode\getPromocodeModel;
use function AGhorab\LaravelPromocode\getPromocodeUsageTable;
use function AGhorab\LaravelPromocode\getPromocodeUsageTablePromocodeIdField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromocodeUsage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): PromocodeUsageFactory
    {
        return new PromocodeUsageFactory();
    }

    /**
     * @param  array<string,scalar>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(getPromocodeUsageTable());
    }

    /**
     * @return BelongsTo<PromocodeUsage,Promocode>
     */
    public function promocode(): BelongsTo
    {
        return $this->belongsTo(
            getPromocodeModel(),
            getPromocodeUsageTablePromocodeIdField(),
        );
    }
}
