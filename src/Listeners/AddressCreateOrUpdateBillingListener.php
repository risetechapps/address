<?php

namespace RiseTech\Address\Listeners;

use RiseTech\Address\Address;
use RiseTech\Address\Events\Address\AddressCreateOrUpdateBillingEvent;
use RiseTech\Address\Model\Address as AddressModel;

class AddressCreateOrUpdateBillingListener
{
    public function __construct()
    {
    }

    public function handle(AddressCreateOrUpdateBillingEvent $event): void
    {

        try {
            $created = !is_null($event->model->address);
            $BillingAddresses = $event->request->input('address_billing', []);


            if ($created) {
                $event->model->addressBilling()->delete();
            }

            foreach ($BillingAddresses as $address) {
                $address = Address::fillWithDefault($address, $event->model);

                $address['address_type'] = get_class($event->model);
                $address['address_id'] = $event->model->getKey();
                $address['type'] = 'billing';
                AddressModel::create($address);
            }


        } catch (\Exception $exception) {

        }
    }
}
