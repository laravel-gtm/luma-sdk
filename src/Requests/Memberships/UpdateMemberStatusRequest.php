<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Memberships;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateMemberStatusRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $userId,
        private readonly string $status,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/memberships/members/update-status';
    }

    protected function defaultBody(): array
    {
        return [
            'user_id' => $this->userId,
            'status' => $this->status,
        ];
    }
}
