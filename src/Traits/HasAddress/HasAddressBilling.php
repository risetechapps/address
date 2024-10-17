<?php

namespace RiseTech\Address\Traits\HasAddress;

use Illuminate\Database\Eloquent\Relations\HasMany;
use RiseTech\Address\Events\Address\AddressCreateOrUpdateBillingEvent;
use RiseTech\Address\Model\Address;

trait HasAddressBilling
{
    public static function bootHasAddressBilling()
    {
        static::saved(function ($model) {
            event(new AddressCreateOrUpdateBillingEvent($model));
        });

    }

    public function addressBilling(): HasMany
    {
        return $this->hasMany(Address::class, 'address_id')->where('type', 'billing');
    }
}
