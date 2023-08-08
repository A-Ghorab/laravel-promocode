<?php

namespace AGhorab\LaravelPromocode\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class PromocodeUsage extends Model
{
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
