<?php

namespace AGhorab\LaravelPromocode\Models;

use AGhorab\LaravelPromocode\Database\Factories\PromocodeFactory;
use function AGhorab\LaravelPromocode\getBoundedUserModelName;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionModel;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTablePromocodeIdField;
use function AGhorab\LaravelPromocode\getPromocodeRedemptionTableUserIdField;
use function AGhorab\LaravelPromocode\getPromocodeTableName;
use function AGhorab\LaravelPromocode\getPromocodeTableUserIdFieldName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $code
 * @property int|null $total_usages
 * @property User|null $boundedUser
 * @property bool $multi_use
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $redemptions_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|self available()
 * @method static \Illuminate\Database\Eloquent\Builder|self hasUsage()
 * @method static \Illuminate\Database\Eloquent\Builder|self hasUsageForUser()
 * @method static \Illuminate\Database\Eloquent\Builder|self hasUsageForAnyone()
 * @method static \Illuminate\Database\Eloquent\Builder|self notBounded()
 * @method static self findByCode(string $code)
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
     * @var array<string,string>
     */
    protected $casts = [
        'expired_at' => 'datetime',
        'total_usages' => 'integer',
        'multi_use' => 'boolean',
        'details' => 'json',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array<string>
     */
    protected $withCount = ['redemptions'];

    /**
     * @param  array<string,scalar>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(getPromocodeTableName());
    }

    protected static function newFactory(): PromocodeFactory
    {
        return new PromocodeFactory();
    }

    /**
     * @return BelongsTo<Promocode,User>
     */
    public function boundedUser(): BelongsTo
    {
        return $this->belongsTo(
            getBoundedUserModelName(),
            getPromocodeTableUserIdFieldName(),
        );
    }

    /**
     * @return HasMany<PromocodeRedemption>
     */
    public function redemptions(): HasMany
    {
        return $this->hasMany(
            getPromocodeRedemptionModel(),
            getPromocodeRedemptionTablePromocodeIdField()
        );
    }

    /**
     * @param  Builder<Promocode>  $builder
     */
    public function scopeAvailable(Builder $builder): void
    {
        $builder->whereNull('expired_at')->orWhere('expired_at', '>', now());
    }

    /**
     * @param  Builder<Promocode>  $builder
     */
    public function scopeHasUsage(Builder $builder): void
    {
        $builder->whereNull('total_usages')->orWhereHas('redemptions', operator: '<', count: DB::raw('total_usages'));
    }

    /**
     * @param  Builder<Promocode>  $builder
     */
    public function scopeHasUsageForUser(Builder $builder, User $user): void
    {
        $builder
            ->hasUsage()
            ->where(fn (Builder $builder) => $builder->where('multi_use', true)->orWhereDoesntHave('redemptions', fn (Builder $builder) => $builder->where(getPromocodeRedemptionTableUserIdField(), $user->getAuthIdentifier())))
            ->where(fn (Builder $builder) => $builder->notBounded()->orWhere(getPromocodeTableUserIdFieldName(), $user->getAuthIdentifier()));
    }

    /**
     * @param  Builder<Promocode>  $builder
     */
    public function scopeHasUsageForAnyone(Builder $builder): void
    {
        $builder->hasUsage()->notBounded();
    }

    /**
     * @param  Builder<Promocode>  $builder
     */
    public function scopeNotBounded(Builder $builder): void
    {
        $builder->where(function (Builder $builder) {
            $builder->whereNull(getPromocodeTableUserIdFieldName());
        });
    }

    /**
     * @param  Builder<Promocode>  $builder
     */
    public function scopeFindByCode(Builder $builder, string $code): self
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
        if ($this->redemptions_count === null) {
            $this->loadCount('redemptions');
        }

        return $this->isUnlimited() || ($this->total_usages - $this->redemptions_count) > 0;
    }

    public function allowedForUser(User $user): bool
    {
        return $this->boundedUser === null || $this->boundedUser->is($user);
    }

    public function appliedByUser(User $user): bool
    {
        return $this->whereRelation('redemptions', getPromocodeRedemptionTableUserIdField(), $user->id)->exists();
    }

    public function getDetail(string $key, mixed $fallback = null): mixed
    {
        return $this->details[$key] ?? $fallback;
    }
}
