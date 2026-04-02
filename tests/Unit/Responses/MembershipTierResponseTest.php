<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\AccessInfoType;
use LaravelGtm\LumaSdk\Responses\AccessInfoResponse;
use LaravelGtm\LumaSdk\Responses\MembershipTierResponse;

it('creates a membership tier response from array', function (): void {
    $response = MembershipTierResponse::fromArray([
        'id' => 'tier_123',
        'name' => 'Premium',
        'description' => 'Premium membership',
        'tint_color' => '#gold',
        'access_info' => [
            'type' => 'payment-recurring',
            'require_approval' => false,
            'currency' => 'usd',
            'stripe_account_id' => 'acct_123',
            'stripe_product_id' => 'prod_123',
            'stripe_monthly_price_id' => 'price_m123',
            'amount_monthly' => 999,
            'stripe_yearly_price_id' => 'price_y123',
            'amount_yearly' => 9999,
        ],
    ]);

    expect($response->id)->toBe('tier_123');
    expect($response->name)->toBe('Premium');
    expect($response->accessInfo)->toBeInstanceOf(AccessInfoResponse::class);
    expect($response->accessInfo->type)->toBe(AccessInfoType::PaymentRecurring);
    expect($response->accessInfo->amountMonthly)->toBe(999);
});
