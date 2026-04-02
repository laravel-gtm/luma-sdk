<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Memberships;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Adds a member to a membership tier.
 *
 * `POST /v1/memberships/members/add`
 */
class AddMemberRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<mixed>|null  $registrationAnswers
     */
    public function __construct(
        private readonly string $email,
        private readonly string $membershipTierId,
        private readonly ?array $registrationAnswers = null,
        private readonly ?bool $skipPayment = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/memberships/members/add';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'email' => $this->email,
            'membership_tier_id' => $this->membershipTierId,
            'registration_answers' => $this->registrationAnswers,
            'skip_payment' => $this->skipPayment,
        ], fn (mixed $value): bool => $value !== null);
    }
}
