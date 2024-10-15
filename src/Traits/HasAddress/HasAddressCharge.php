<?php

namespace RiseTech\Address\Traits\HasAddress;

use Illuminate\Database\Eloquent\Relations\HasMany;
use RiseTech\Address\Events\Address\AddressCreateOrUpdateChargeEvent;
use RiseTech\Address\Model\Address;

trait HasAddressCharge
{
    public static function bootHasAddressCharge()
    {
        static::saved(function ($model) {
            event(new AddressCreateOrUpdateChargeEvent($model));
        });

    }

    public function addressCharge(): HasMany
    {
        return $this->hasMany(Address::class, 'address_id')->where('type', 'charge');
    }
}
