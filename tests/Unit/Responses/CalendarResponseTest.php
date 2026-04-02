<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\CalendarResponse;

it('creates a calendar response from array', function (): void {
    $response = CalendarResponse::fromArray([
        'id' => 'cal_123',
        'name' => 'My Calendar',
        'slug' => 'my-calendar',
        'avatar_url' => 'https://example.test/avatar.jpg',
        'url' => 'https://lu.ma/my-calendar',
        'description' => 'A test calendar',
        'is_personal' => false,
        'twitter_handle' => 'testcal',
    ]);

    expect($response->id)->toBe('cal_123');
    expect($response->name)->toBe('My Calendar');
    expect($response->slug)->toBe('my-calendar');
    expect($response->isPersonal)->toBeFalse();
    expect($response->twitterHandle)->toBe('testcal');
    expect($response->instagramHandle)->toBeNull();
});
