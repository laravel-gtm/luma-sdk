<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\ValueObjects\GooglePlaceId;

it('creates from a string', function (): void {
    $placeId = new GooglePlaceId('ChIJN1t_tDeuEmsRUsoyG83frY4');

    expect($placeId->value)->toBe('ChIJN1t_tDeuEmsRUsoyG83frY4');
});

it('creates from an API location array', function (): void {
    $placeId = GooglePlaceId::fromArray(['place_id' => 'ChIJN1t_tDeuEmsRUsoyG83frY4']);

    expect($placeId->value)->toBe('ChIJN1t_tDeuEmsRUsoyG83frY4');
});

it('serializes to the API location format', function (): void {
    $placeId = new GooglePlaceId('ChIJN1t_tDeuEmsRUsoyG83frY4');

    expect($placeId->toArray())->toBe(['place_id' => 'ChIJN1t_tDeuEmsRUsoyG83frY4']);
});

it('throws for empty place ID', function (): void {
    new GooglePlaceId('');
})->throws(InvalidArgumentException::class);

it('throws for whitespace-only place ID', function (): void {
    new GooglePlaceId('   ');
})->throws(InvalidArgumentException::class);

it('throws when place_id key is missing from array', function (): void {
    GooglePlaceId::fromArray(['id' => 'something']);
})->throws(InvalidArgumentException::class);

it('can be cast to string', function (): void {
    $placeId = new GooglePlaceId('ChIJN1t_tDeuEmsRUsoyG83frY4');

    expect((string) $placeId)->toBe('ChIJN1t_tDeuEmsRUsoyG83frY4');
});
