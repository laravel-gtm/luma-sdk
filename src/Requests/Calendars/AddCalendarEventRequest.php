<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\ValueObjects\GooglePlaceId;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class AddCalendarEventRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $data
     */
    private function __construct(
        private readonly array $data,
    ) {}

    /**
     * @param  array{longitude: float, latitude: float}|null  $coordinate
     */
    public static function forExternal(
        string $url,
        string $name,
        LumaDate $startAt,
        LumaDuration $durationInterval,
        string $timezone,
        ?string $submissionMode = null,
        ?GooglePlaceId $geoAddressJson = null,
        ?string $host = null,
        ?float $geoLongitude = null,
        ?float $geoLatitude = null,
        ?array $coordinate = null,
    ): self {
        return new self(array_filter([
            'platform' => 'external',
            'url' => $url,
            'name' => $name,
            'start_at' => $startAt->toString(),
            'duration_interval' => $durationInterval->toString(),
            'timezone' => $timezone,
            'submission_mode' => $submissionMode,
            'geo_address_json' => $geoAddressJson?->toArray(),
            'host' => $host,
            'geo_longitude' => $geoLongitude,
            'geo_latitude' => $geoLatitude,
            'coordinate' => $coordinate,
        ], fn (mixed $value): bool => $value !== null));
    }

    public static function forLuma(
        string $eventApiId,
        ?string $submissionMode = null,
    ): self {
        return new self(array_filter([
            'platform' => 'luma',
            'event_api_id' => $eventApiId,
            'submission_mode' => $submissionMode,
        ], fn (mixed $value): bool => $value !== null));
    }

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/add-event';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
