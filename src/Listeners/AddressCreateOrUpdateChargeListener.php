<?php

namespace RiseTech\Address\Listeners;

use Illuminate\Support\Arr;
use RiseTech\Address\Address;
use RiseTech\Address\Events\Address\AddressCreateOrUpdateChargeEvent;
use RiseTech\Address\Model\Address as AddressModel;

class AddressCreateOrUpdateChargeListener
{
    public function __construct()
    {
    }

    public function handle(AddressCreateOrUpdateChargeEvent $event): void
    {

        try {
            $created = !is_null($event->model->address);
            $chargeAddresses = $event->request->input('address_charge', []);


            if ($created) {
                $event->model->addressCharge()->delete();
            }

            foreach ($chargeAddresses as $address) {
                $address = Address::fillWithDefault($address, $event->model);

                $address['address_type'] = get_class($event->model);
                $address['address_id'] = $event->model->getKey();
                $address['type'] = 'charge';
                AddressModel::create($address);
            }


        } catch (\Exception $exception) {

        }
    }
}
