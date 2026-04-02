<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\Visibility;
use LaravelGtm\LumaSdk\ValueObjects\GooglePlaceId;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;

readonly class EventResponse
{
    /**
     * @param  array<mixed>  $registrationQuestions
     */
    public function __construct(
        public string $id,
        public ?string $userId,
        public ?string $calendarId,
        public LumaDate $startAt,
        public ?LumaDate $endAt,
        public LumaDate $createdAt,
        public ?LumaDuration $durationInterval,
        public ?string $timezone,
        public string $name,
        public ?string $description,
        public ?string $descriptionMd,
        public ?GooglePlaceId $geoAddressJson,
        public ?float $geoLatitude,
        public ?float $geoLongitude,
        public ?string $meetingUrl,
        public ?string $coverUrl,
        public string $url,
        public ?Visibility $visibility,
        public array $registrationQuestions,
        public ?string $feedbackEmail,
        public ?string $apiId,
        public ?string $userApiId,
        public ?string $calendarApiId,
        public ?string $zoomMeetingUrl,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            userId: isset($data['user_id']) ? (string) $data['user_id'] : null,
            calendarId: isset($data['calendar_id']) ? (string) $data['calendar_id'] : null,
            startAt: LumaDate::fromString((string) $data['start_at']),
            endAt: isset($data['end_at']) ? LumaDate::fromString((string) $data['end_at']) : null,
            createdAt: LumaDate::fromString((string) $data['created_at']),
            durationInterval: isset($data['duration_interval']) ? LumaDuration::fromString((string) $data['duration_interval']) : null,
            timezone: isset($data['timezone']) ? (string) $data['timezone'] : null,
            name: (string) $data['name'],
            description: isset($data['description']) ? (string) $data['description'] : null,
            descriptionMd: isset($data['description_md']) ? (string) $data['description_md'] : null,
            geoAddressJson: isset($data['geo_address_json']) && is_array($data['geo_address_json']) && isset($data['geo_address_json']['place_id']) ? GooglePlaceId::fromArray($data['geo_address_json']) : null,
            geoLatitude: isset($data['geo_latitude']) ? (float) $data['geo_latitude'] : null,
            geoLongitude: isset($data['geo_longitude']) ? (float) $data['geo_longitude'] : null,
            meetingUrl: isset($data['meeting_url']) ? (string) $data['meeting_url'] : null,
            coverUrl: isset($data['cover_url']) ? (string) $data['cover_url'] : null,
            url: (string) $data['url'],
            visibility: isset($data['visibility']) ? Visibility::from((string) $data['visibility']) : null,
            registrationQuestions: (array) ($data['registration_questions'] ?? []),
            feedbackEmail: isset($data['feedback_email']) ? (string) $data['feedback_email'] : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
            userApiId: isset($data['user_api_id']) ? (string) $data['user_api_id'] : null,
            calendarApiId: isset($data['calendar_api_id']) ? (string) $data['calendar_api_id'] : null,
            zoomMeetingUrl: isset($data['zoom_meeting_url']) ? (string) $data['zoom_meeting_url'] : null,
        );
    }
}
