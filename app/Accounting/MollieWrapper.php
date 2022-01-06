<?php


namespace App\Accounting;


use Mollie\Laravel\MollieManager;

class MollieWrapper
{
    const CACHE_PAYMENTS = 'mollie_manager_payments';

    public function __construct(
        public MollieManager $manager
    )
    {
    }

    public function availablePayments()
    {
        return \Cache::remember(self::CACHE_PAYMENTS, now()->addDay(), fn() => collect(
            $this->manager->api()->methods()->allActive())->map(fn($o) => [
                'id' => $o->id, 'name' => $o->description, 'image' => $o->image->svg
            ]
        )->toArray());
    }

}