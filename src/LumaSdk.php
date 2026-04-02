<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use LaravelGtm\LumaSdk\Requests\GetSelfRequest;
use LaravelGtm\LumaSdk\Requests\LookupEntityRequest;
use LaravelGtm\LumaSdk\Resources\CalendarResource;
use LaravelGtm\LumaSdk\Resources\EventResource;
use LaravelGtm\LumaSdk\Resources\MembershipResource;
use LaravelGtm\LumaSdk\Resources\OrganizationResource;
use LaravelGtm\LumaSdk\Resources\WebhookResource;
use LaravelGtm\LumaSdk\Responses\EntityResponse;
use LaravelGtm\LumaSdk\Responses\UserResponse;

class LumaSdk
{
    public function __construct(private readonly LumaConnector $connector) {}

    public static function make(?string $baseUrl = null, ?string $token = null): self
    {
        return new self(new LumaConnector($baseUrl, $token));
    }

    public function getSelf(): UserResponse
    {
        $response = $this->connector->send(new GetSelfRequest);

        /** @var UserResponse */
        return $response->dtoOrFail();
    }

    public function lookupEntity(string $slug): EntityResponse
    {
        /** @var EntityResponse */
        return $this->connector->send(new LookupEntityRequest($slug))->dtoOrFail();
    }

    public function events(): EventResource
    {
        return new EventResource($this->connector);
    }

    public function calendars(): CalendarResource
    {
        return new CalendarResource($this->connector);
    }

    public function memberships(): MembershipResource
    {
        return new MembershipResource($this->connector);
    }

    public function webhooks(): WebhookResource
    {
        return new WebhookResource($this->connector);
    }

    public function organizations(): OrganizationResource
    {
        return new OrganizationResource($this->connector);
    }
}
