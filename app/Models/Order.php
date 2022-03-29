<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Order
 * @package App\Models
 */
class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(fn (Order $order) => $order->{$order->getKeyName()} = (string) Str::uuid());
    }

    public const STATE_ANEW = 'anew',
        STATE_MODERATION = 'moderation',
        STATE_APPROVED = 'approved',
        STATE_REJECTED = 'rejected',
        STATE_DONE = 'done';

    public const APPROVED_AT = 'approved_at',
        REJECTED_AT = 'rejected_at';

    /**
     * @var string[]
     */
    protected $fillable = [
        'state',
        'manager_id',
        'customer_id',
        'customer_firstname',
        'customer_lastname',
        'customer_phone',
        'comment',
        self::APPROVED_AT,
        self::REJECTED_AT
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        self::APPROVED_AT,
        self::REJECTED_AT
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['count', 'price']);
    }

    /**
     * @return float
     */
    public function getTotalPriceAttribute(): float
    {
        return DB::table('order_product')
            ->where('order_uuid', '=', $this->uuid)
            ->select(DB::raw('SUM(count * price) as total_price'))
            ->value('total_price');
    }

    /**
     * @param string $state
     * @return array|\ArrayAccess|mixed
     */
    public static function getVerbalState(string $state)
    {
        return Arr::get(self::getVerbalStates(), $state);
    }

    /**
     * @return string[]
     */
    public static function getVerbalStates(): array
    {
        return [
            self::STATE_ANEW => 'NEW',
            self::STATE_MODERATION => 'MODERATION',
            self::STATE_APPROVED => 'APPROVED',
            self::STATE_REJECTED => 'REJECTED',
            self::STATE_DONE => 'DONE',
        ];
    }
}
