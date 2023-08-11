<?php

namespace AGhorab\LaravelPromocode\Models;

use AGhorab\LaravelPromocode\Database\Factories\PromocodeUsageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class PromocodeUsage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return new PromocodeUsageFactory();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(Config::get('promocodes.models.promocode_usage_table.table_name'));
    }

    public function promocode()
    {
        return $this->belongsTo(
            config('promocodes.models.promocodes.model'),
            config('promocodes.models.promocode_usage_table.promocode_foreign_id'),
        );
    }
}
