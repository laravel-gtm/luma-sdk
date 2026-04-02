<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\AccessInfoType;

class AccessInfoResponse
{
    public function __construct(
        public readonly AccessInfoType $type,
        public readonly bool $requireApproval,
        public readonly ?int $amount,
        public readonly ?string $currency,
        public readonly ?string $stripeAccountId,
        public readonly ?string $stripeProductId,
        public readonly ?string $stripeMonthlyPriceId,
        public readonly ?int $amountMonthly,
        public readonly ?string $stripeYearlyPriceId,
        public readonly ?int $amountYearly,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: AccessInfoType::from((string) $data['type']),
            requireApproval: (bool) ($data['require_approval'] ?? false),
            amount: isset($data['amount']) ? (int) $data['amount'] : null,
            currency: isset($data['currency']) ? (string) $data['currency'] : null,
            stripeAccountId: isset($data['stripe_account_id']) ? (string) $data['stripe_account_id'] : null,
            stripeProductId: isset($data['stripe_product_id']) ? (string) $data['stripe_product_id'] : null,
            stripeMonthlyPriceId: isset($data['stripe_monthly_price_id']) ? (string) $data['stripe_monthly_price_id'] : null,
            amountMonthly: isset($data['amount_monthly']) ? (int) $data['amount_monthly'] : null,
            stripeYearlyPriceId: isset($data['stripe_yearly_price_id']) ? (string) $data['stripe_yearly_price_id'] : null,
            amountYearly: isset($data['amount_yearly']) ? (int) $data['amount_yearly'] : null,
        );
    }
}
