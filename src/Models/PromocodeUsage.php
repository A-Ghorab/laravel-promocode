<?php

namespace AGhorab\LaravelPromocode\Models;

use AGhorab\LaravelPromocode\Database\Factories\PromocodeUsageFactory;
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

        $this->setTable(config('promocodes.models.promocode_usage_table.table_name'));
    }

    /**
     * @return BelongsTo<PromocodeUsage,Promocode>
     */
    public function promocode(): BelongsTo
    {
        return $this->belongsTo(
            config('promocodes.models.promocodes.model'),
            config('promocodes.models.promocode_usage_table.promocode_foreign_id'),
        );
    }
}
