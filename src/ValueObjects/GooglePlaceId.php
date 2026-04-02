<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\ValueObjects;

use InvalidArgumentException;

final readonly class GooglePlaceId
{
    public function __construct(
        public string $value,
    ) {
        if (trim($value) === '') {
            throw new InvalidArgumentException('Google Place ID cannot be empty.');
        }
    }

    /**
     * Create from the Luma API location payload.
     *
     * Expects an array with a "place_id" key.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        if (! isset($data['place_id']) || ! is_string($data['place_id'])) {
            throw new InvalidArgumentException('Missing or invalid "place_id" in location data.');
        }

        return new self($data['place_id']);
    }

    /**
     * Serialize to the Luma API location format.
     *
     * @return array{place_id: string}
     */
    public function toArray(): array
    {
        return ['place_id' => $this->value];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
