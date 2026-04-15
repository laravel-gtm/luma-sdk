<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\ValueObjects\FeedbackEmail;
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;

it('creates from an API array with enabled and delay', function (): void {
    $feedback = FeedbackEmail::fromArray(['enabled' => true, 'delay' => 'PT30M']);

    expect($feedback->enabled)->toBeTrue();
    expect($feedback->delay)->toBeInstanceOf(LumaDuration::class);
    expect($feedback->delay?->toString())->toBe('PT30M');
});

it('creates from an API array with enabled only', function (): void {
    $feedback = FeedbackEmail::fromArray(['enabled' => false]);

    expect($feedback->enabled)->toBeFalse();
    expect($feedback->delay)->toBeNull();
});

it('serializes to the API format with delay', function (): void {
    $feedback = FeedbackEmail::fromArray(['enabled' => true, 'delay' => 'PT0M']);

    expect($feedback->toArray())->toBe(['enabled' => true, 'delay' => 'PT0S']);
});

it('serializes to the API format without delay', function (): void {
    $feedback = FeedbackEmail::fromArray(['enabled' => true]);

    expect($feedback->toArray())->toBe(['enabled' => true]);
});

it('throws when enabled key is missing', function (): void {
    FeedbackEmail::fromArray(['delay' => 'PT30M']);
})->throws(InvalidArgumentException::class);

it('throws when enabled is not a boolean', function (): void {
    FeedbackEmail::fromArray(['enabled' => 'yes']);
})->throws(InvalidArgumentException::class);
