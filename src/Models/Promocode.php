<?php

namespace AGhorab\LaravelPromocode\Models;

use AGhorab\LaravelPromocode\Database\Factories\PromocodeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;

/**
 * App\Models\Promocode
 *
 * @property int $id
 * @property string $code
 * @property int|null $total_usages
 * @property User|null $boundedUser
 * @property bool $multi_use
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $usages_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promocode available()
 * @method static Promocode findByCode(string $code)
 */
class Promocode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['*'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
        'total_usages' => 'integer',
        'multi_use' => 'boolean',
        'details' => 'json',
    ];

    protected $withCount = ['usages'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('promocodes.models.promocodes.table_name'));
    }

    protected static function newFactory()
    {
        return new PromocodeFactory();
    }

    public function boundedUser(): BelongsTo
    {
        return $this->belongsTo(
            config('promocodes.models.users.model'),
            config('promocodes.models.promocodes.bound_to_user_id_foreign_id'),
        );
    }

    public function usages(): HasMany
    {
        return $this->hasMany(
            getPromocodeUsageModel(),
            config('promocodes.models.promocode_usage_table.promocode_foreign_id')
        );
    }

    public function scopeAvailable(Builder $builder): void
    {
        $builder->whereNull('expired_at')->orWhere('expired_at', '>', now());
    }

    public function scopeFindByCode(Builder $builder, string $code): Promocode
    {
        return $builder->where('code', $code)->firstOrFail();
    }

    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at->isBefore(now());
    }

    public function isUnlimited(): bool
    {
        return $this->total_usages === null;
    }

    public function hasUsagesLeft(): bool
    {
        return $this->isUnlimited() || ($this->total_usages - $this->usages_count) > 0;
    }

    public function allowedForUser(User $user): bool
    {
        return $this->boundedUser === null || $this->boundedUser->is($user);
    }

    public function appliedByUser(User $user): bool
    {
        return $this->whereRelation('usages', config('promocodes.models.promocode_usage_table.user_id_foreign_id'), $user->id)->exists();
    }

    public function getDetail(string $key, mixed $fallback = null): mixed
    {
        return $this->details[$key] ?? $fallback;
    }
}
