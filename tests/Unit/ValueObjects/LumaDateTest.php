<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

it('parses an ISO 8601 date string from the API', function (): void {
    $date = LumaDate::fromString('2022-10-04T05:20:00.000Z');

    expect($date->dateTime->format('Y-m-d H:i:s'))
        ->toBe('2022-10-04 05:20:00');
    expect($date->dateTime->getTimezone()->getName())
        ->toBe('UTC');
});

it('serializes back to Luma API format', function (): void {
    $date = LumaDate::fromString('2022-10-04T05:20:00.000Z');

    expect($date->toString())->toBe('2022-10-04T05:20:00.000Z');
});

it('round-trips through fromString and toString', function (): void {
    $original = '2026-01-15T14:30:00.000Z';
    $date = LumaDate::fromString($original);

    expect((string) $date)->toBe($original);
});

it('creates from a DateTimeImmutable instance', function (): void {
    $dt = new DateTimeImmutable('2026-06-15 10:00:00', new DateTimeZone('America/New_York'));
    $date = LumaDate::fromDateTime($dt);

    expect($date->dateTime->getTimezone()->getName())->toBe('UTC');
    expect($date->toString())->toBe('2026-06-15T14:00:00.000Z');
});

it('converts to a specific timezone', function (): void {
    $date = LumaDate::fromString('2022-10-04T05:20:00.000Z');
    $eastern = $date->toTimezone('America/New_York');

    expect($eastern->format('Y-m-d H:i:s'))->toBe('2022-10-04 01:20:00');
});

it('can be cast to string', function (): void {
    $date = LumaDate::fromString('2022-10-04T05:20:00.000Z');

    expect((string) $date)->toBe('2022-10-04T05:20:00.000Z');
});
