<?php

namespace RiseTech\Address\Traits\HasAddress;

use Illuminate\Database\Eloquent\Relations\HasMany;
use RiseTech\Address\Events\Address\AddressCreateOrUpdateChargeEvent;
use RiseTech\Address\Model\Address;

trait HasAddressDelivery
{
    public static function HasAddressDelivery()
    {
        static::saved(function ($model) {
            event(new AddressCreateOrUpdateChargeEvent($model));
        });

    }

    public function addressDelivery(): HasMany
    {
        return $this->hasMany(Address::class, 'address_id')->where('type', 'delivery');
    }
}
