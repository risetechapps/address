<?php

namespace RiseTech\Address\Listeners;

use Illuminate\Support\Arr;
use RiseTech\Address\Events\Address\AddressCreateOrUpdateDefaultEvent;
use RiseTech\Address\Model\Address;

class AddressCreateOrUpdateDefaultListener
{
    public function __construct()
    {
    }

    public function handle(AddressCreateOrUpdateDefaultEvent $event): void
    {
        try {

            $address = [];

            $created = !is_null($event->model->address);

            if ($event->request->has('address')) {
                $address = $event->request->input('address');
            }else{
                if(!empty(\RiseTech\Address\Address::getAddress())){
                    $address = \RiseTech\Address\Address::getAddress();
                }
            }

            if (!Arr::exists($address, 'zip_code')) {
                $address = Arr::add($address, 'zip_code', $created ?
                    $event->model->address->getOriginal('zip_code') : null);
            }
            if (!Arr::exists($address, 'state')) {
                $address = Arr::add($address, 'state', $created ?
                    $event->model->address->getOriginal('state') : null);
            }
            if (!Arr::exists($address, 'city')) {
                $address = Arr::add($address, 'city', $created ?
                    $event->model->address->getOriginal('city') : null);
            }
            if (!Arr::exists($address, 'district')) {
                $address = Arr::add($address, 'district', $created ?
                    $event->model->address->getOriginal('district') : null);
            }
            if (!Arr::exists($address, 'address')) {
                $address = Arr::add($address, 'address', $created ?
                    $event->model->address->getOriginal('address') : null);
            }
            if (!Arr::exists($address, 'number')) {
                $address = Arr::add($address, 'number', $created ?
                    $event->model->address->getOriginal('number') : null);
            }
            if (!Arr::exists($address, 'complement')) {
                $address = Arr::add($address, 'complement', $created ?
                    $event->model->address->getOriginal('complement') : null);
            }

            if($created === true){
                $event->model->address->update($address);
            }else{
                $address['address_type'] = get_class($event->model);
                $address['address_id'] = $event->model->getKey();
                $address['type'] = 'default';
                Address::create($address);
            }

        } catch (\Exception $exception) {

        }
    }
}
