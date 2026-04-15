<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\ValueObjects;

use InvalidArgumentException;

final readonly class FeedbackEmail
{
    public function __construct(
        public bool $enabled,
        public ?LumaDuration $delay = null,
    ) {}

    /**
     * Create from the Luma API feedback email payload.
     *
     * Expects an array with an "enabled" key (bool) and optional "delay" key (ISO 8601 duration).
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        if (! isset($data['enabled']) || ! is_bool($data['enabled'])) {
            throw new InvalidArgumentException('Missing or invalid "enabled" in feedback email data.');
        }

        return new self(
            enabled: $data['enabled'],
            delay: isset($data['delay']) && is_string($data['delay']) ? LumaDuration::fromString($data['delay']) : null,
        );
    }

    /**
     * Serialize to the Luma API feedback email format.
     *
     * @return array{enabled: bool, delay?: string}
     */
    public function toArray(): array
    {
        $result = ['enabled' => $this->enabled];

        if ($this->delay !== null) {
            $result['delay'] = $this->delay->toString();
        }

        return $result;
    }
}
