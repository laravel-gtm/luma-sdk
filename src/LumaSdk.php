<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use LaravelGtm\LumaSdk\Requests\GetSelfRequest;
use LaravelGtm\LumaSdk\Requests\LookupEntityRequest;
use LaravelGtm\LumaSdk\Resources\CalendarResource;
use LaravelGtm\LumaSdk\Resources\EventResource;
use LaravelGtm\LumaSdk\Resources\ImageResource;
use LaravelGtm\LumaSdk\Resources\MembershipResource;
use LaravelGtm\LumaSdk\Resources\OrganizationResource;
use LaravelGtm\LumaSdk\Resources\WebhookResource;
use LaravelGtm\LumaSdk\Responses\EntityResponse;
use LaravelGtm\LumaSdk\Responses\UserResponse;

class LumaSdk
{
    public function __construct(private readonly LumaConnector $connector) {}

    /**
     * Builds a standalone SDK instance.
     *
     * @param  string|null  $baseUrl  Optional API base URL override.
     * @param  string|null  $token  API token sent as `x-luma-api-key`.
     */
    public static function make(?string $baseUrl = null, ?string $token = null): self
    {
        return new self(new LumaConnector($baseUrl, $token));
    }

    /**
     * Retrieves the authenticated account profile.
     *
     * @see GetSelfRequest
     */
    public function getSelf(): UserResponse
    {
        $response = $this->connector->send(new GetSelfRequest);

        /** @var UserResponse */
        return $response->dtoOrFail();
    }

    /**
     * Resolves a public Luma slug into an entity descriptor.
     *
     * @param  string  $slug  Public slug for an event, calendar, or organization.
     *
     * @see LookupEntityRequest
     */
    public function lookupEntity(string $slug): EntityResponse
    {
        /** @var EntityResponse */
        return $this->connector->send(new LookupEntityRequest($slug))->dtoOrFail();
    }

    /**
     * Accesses event-related endpoints.
     */
    public function events(): EventResource
    {
        return new EventResource($this->connector);
    }

    /**
     * Accesses calendar-related endpoints.
     */
    public function calendars(): CalendarResource
    {
        return new CalendarResource($this->connector);
    }

    /**
     * Accesses membership-related endpoints.
     */
    public function memberships(): MembershipResource
    {
        return new MembershipResource($this->connector);
    }

    /**
     * Accesses webhook-related endpoints.
     */
    public function webhooks(): WebhookResource
    {
        return new WebhookResource($this->connector);
    }

    /**
     * Accesses organization-related endpoints.
     */
    public function organizations(): OrganizationResource
    {
        return new OrganizationResource($this->connector);
    }

    /**
     * Accesses image upload endpoints.
     */
    public function images(): ImageResource
    {
        return new ImageResource($this->connector);
    }
}
