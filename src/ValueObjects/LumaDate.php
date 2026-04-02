<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\ValueObjects;

use DateTimeImmutable;
use DateTimeZone;

final readonly class LumaDate
{
    private const string FORMAT = 'Y-m-d\TH:i:s.v\Z';

    public function __construct(
        public DateTimeImmutable $dateTime,
    ) {}

    /**
     * Parse an ISO 8601 date string from the Luma API.
     */
    public static function fromString(string $value): self
    {
        $parsed = DateTimeImmutable::createFromFormat(
            self::FORMAT,
            $value,
            new DateTimeZone('UTC'),
        );

        if ($parsed === false) {
            // Fallback: try standard ISO 8601 parsing
            $parsed = new DateTimeImmutable($value, new DateTimeZone('UTC'));
        }

        return new self($parsed->setTimezone(new DateTimeZone('UTC')));
    }

    /**
     * Create from a DateTimeImmutable instance.
     */
    public static function fromDateTime(DateTimeImmutable $dateTime): self
    {
        return new self($dateTime->setTimezone(new DateTimeZone('UTC')));
    }

    /**
     * Serialize back to the Luma API format.
     */
    public function toString(): string
    {
        return $this->dateTime->setTimezone(new DateTimeZone('UTC'))->format(self::FORMAT);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Convert to a specific timezone for display.
     */
    public function toTimezone(string $timezone): DateTimeImmutable
    {
        return $this->dateTime->setTimezone(new DateTimeZone($timezone));
    }
}
