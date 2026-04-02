<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;

it('parses an ISO 8601 duration string', function (): void {
    $duration = LumaDuration::fromString('P1DT12H30M');

    expect($duration->interval->d)->toBe(1);
    expect($duration->interval->h)->toBe(12);
    expect($duration->interval->i)->toBe(30);
});

it('serializes back to ISO 8601 format', function (): void {
    $duration = LumaDuration::fromString('P1DT12H30M');

    expect($duration->toString())->toBe('P1DT12H30M');
});

it('round-trips a time-only duration', function (): void {
    $duration = LumaDuration::fromString('PT1H');

    expect((string) $duration)->toBe('PT1H');
});

it('handles a zero duration', function (): void {
    $duration = LumaDuration::fromInterval(new DateInterval('PT0S'));

    expect($duration->toString())->toBe('PT0S');
});

it('calculates total seconds', function (): void {
    $duration = LumaDuration::fromString('PT1H30M');

    expect($duration->toSeconds())->toBe(5400);
});

it('calculates total seconds for complex durations', function (): void {
    $duration = LumaDuration::fromString('P1DT12H30M');

    // 1 day (86400) + 12 hours (43200) + 30 minutes (1800) = 131400
    expect($duration->toSeconds())->toBe(131400);
});

it('throws for invalid duration strings', function (): void {
    LumaDuration::fromString('invalid');
})->throws(InvalidArgumentException::class);

it('creates from a DateInterval instance', function (): void {
    $interval = new DateInterval('PT2H15M');
    $duration = LumaDuration::fromInterval($interval);

    expect($duration->toString())->toBe('PT2H15M');
});

it('can be cast to string', function (): void {
    $duration = LumaDuration::fromString('P1DT12H30M');

    expect((string) $duration)->toBe('P1DT12H30M');
});
