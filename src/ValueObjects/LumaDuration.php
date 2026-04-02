<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\ValueObjects;

use DateInterval;
use InvalidArgumentException;

final readonly class LumaDuration
{
    public function __construct(
        public DateInterval $interval,
    ) {}

    /**
     * Parse an ISO 8601 duration string from the Luma API.
     *
     * Examples: "PT1H", "P1DT12H30M", "PT30M"
     */
    public static function fromString(string $value): self
    {
        if (! str_starts_with($value, 'P')) {
            throw new InvalidArgumentException("Invalid ISO 8601 duration: {$value}");
        }

        return new self(new DateInterval($value));
    }

    /**
     * Create from a DateInterval instance.
     */
    public static function fromInterval(DateInterval $interval): self
    {
        return new self($interval);
    }

    /**
     * Serialize back to ISO 8601 duration format for the Luma API.
     */
    public function toString(): string
    {
        $result = 'P';

        if ($this->interval->y > 0) {
            $result .= $this->interval->y.'Y';
        }

        if ($this->interval->m > 0) {
            $result .= $this->interval->m.'M';
        }

        if ($this->interval->d > 0) {
            $result .= $this->interval->d.'D';
        }

        $timePart = '';

        if ($this->interval->h > 0) {
            $timePart .= $this->interval->h.'H';
        }

        if ($this->interval->i > 0) {
            $timePart .= $this->interval->i.'M';
        }

        if ($this->interval->s > 0) {
            $timePart .= $this->interval->s.'S';
        }

        if ($timePart !== '') {
            $result .= 'T'.$timePart;
        }

        // "P" alone is invalid; at least one component is required
        if ($result === 'P') {
            $result = 'PT0S';
        }

        return $result;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Get the total duration in seconds.
     */
    public function toSeconds(): int
    {
        return ($this->interval->y * 365 * 24 * 3600)
            + ($this->interval->m * 30 * 24 * 3600)
            + ($this->interval->d * 24 * 3600)
            + ($this->interval->h * 3600)
            + ($this->interval->i * 60)
            + $this->interval->s;
    }
}
