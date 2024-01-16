<?php

namespace App\Services\Currencies\Models;

use App\Models\Payment;
use App\Services\Currencies\Factories\CurrencyFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Services\Currencies\Models\Currency
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @mixin \Eloquent
 */
class Currency extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public  $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * @return HasMany
     */
    public function payments(): hasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return Factory|CurrencyFactory
     */
    protected static function newFactory():  Factory|CurrencyFactory
    {
        return CurrencyFactory::new();
    }
}
