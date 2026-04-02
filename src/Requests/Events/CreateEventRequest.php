<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Enums\Visibility;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateEventRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<mixed>|null  $registrationQuestions
     * @param  array{longitude: float, latitude: float}|null  $coordinate
     * @param  array<string, mixed>|null  $geoAddressJson
     * @param  array{enabled: bool, delay?: string}|null  $feedbackEmail
     */
    public function __construct(
        private readonly string $name,
        private readonly string $startAt,
        private readonly string $timezone,
        private readonly ?string $endAt = null,
        private readonly ?string $descriptionMd = null,
        private readonly ?string $coverUrl = null,
        private readonly ?string $slug = null,
        private readonly ?string $meetingUrl = null,
        private readonly ?array $coordinate = null,
        private readonly ?array $geoAddressJson = null,
        private readonly ?int $maxCapacity = null,
        private readonly ?Visibility $visibility = null,
        private readonly ?string $tintColor = null,
        private readonly ?bool $showGuestList = null,
        private readonly ?bool $remindersDisabled = null,
        private readonly ?string $phoneNumberRequirement = null,
        private readonly ?string $nameRequirement = null,
        private readonly ?bool $canRegisterForMultipleTickets = null,
        private readonly ?array $registrationQuestions = null,
        private readonly ?array $feedbackEmail = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/create';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'name' => $this->name,
            'start_at' => $this->startAt,
            'timezone' => $this->timezone,
            'end_at' => $this->endAt,
            'description_md' => $this->descriptionMd,
            'cover_url' => $this->coverUrl,
            'slug' => $this->slug,
            'meeting_url' => $this->meetingUrl,
            'coordinate' => $this->coordinate,
            'geo_address_json' => $this->geoAddressJson,
            'max_capacity' => $this->maxCapacity,
            'visibility' => $this->visibility?->value,
            'tint_color' => $this->tintColor,
            'show_guest_list' => $this->showGuestList,
            'reminders_disabled' => $this->remindersDisabled,
            'phone_number_requirement' => $this->phoneNumberRequirement,
            'name_requirement' => $this->nameRequirement,
            'can_register_for_multiple_tickets' => $this->canRegisterForMultipleTickets,
            'registration_questions' => $this->registrationQuestions,
            'feedback_email' => $this->feedbackEmail,
        ], fn (mixed $value): bool => $value !== null);
    }
}
