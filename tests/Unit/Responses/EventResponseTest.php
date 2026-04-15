<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\Visibility;
use LaravelGtm\LumaSdk\Responses\EventResponse;
use LaravelGtm\LumaSdk\ValueObjects\FeedbackEmail;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;

it('creates an event response from array', function (): void {
    $response = EventResponse::fromArray([
        'id' => 'evt_123',
        'user_id' => 'usr_456',
        'calendar_id' => 'cal_789',
        'start_at' => '2024-06-15T18:00:00.000Z',
        'end_at' => '2024-06-15T20:00:00.000Z',
        'created_at' => '2024-06-01T10:00:00.000Z',
        'duration_interval' => 'PT2H',
        'timezone' => 'America/New_York',
        'name' => 'Test Event',
        'description' => 'A test event',
        'description_md' => '# A test event',
        'url' => 'https://lu.ma/test-event',
        'visibility' => 'public',
        'registration_questions' => [],
        'feedback_email' => ['enabled' => true, 'delay' => 'PT30M'],
        'api_id' => 'evt_123',
    ]);

    expect($response->id)->toBe('evt_123');
    expect($response->name)->toBe('Test Event');
    expect($response->startAt)->toBeInstanceOf(LumaDate::class);
    expect($response->endAt)->toBeInstanceOf(LumaDate::class);
    expect($response->durationInterval)->toBeInstanceOf(LumaDuration::class);
    expect($response->durationInterval?->toSeconds())->toBe(7200);
    expect($response->visibility)->toBe(Visibility::Public);
    expect($response->url)->toBe('https://lu.ma/test-event');
    expect($response->feedbackEmail)->toBeInstanceOf(FeedbackEmail::class);
    expect($response->feedbackEmail?->enabled)->toBeTrue();
    expect($response->feedbackEmail?->delay?->toString())->toBe('PT30M');
});

it('handles nullable event fields', function (): void {
    $response = EventResponse::fromArray([
        'id' => 'evt_123',
        'start_at' => '2024-06-15T18:00:00.000Z',
        'created_at' => '2024-06-01T10:00:00.000Z',
        'name' => 'Minimal Event',
        'url' => 'https://lu.ma/minimal',
    ]);

    expect($response->endAt)->toBeNull();
    expect($response->durationInterval)->toBeNull();
    expect($response->meetingUrl)->toBeNull();
    expect($response->coverUrl)->toBeNull();
    expect($response->visibility)->toBeNull();
    expect($response->geoAddressJson)->toBeNull();
});
