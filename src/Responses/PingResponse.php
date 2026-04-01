<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class PingResponse
{
    /**
     * @param  array<string, mixed>  $raw
     */
    public function __construct(
        public readonly bool $ok,
        public readonly array $raw,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromArray(array $payload): self
    {
        $ok = false;

        if (array_key_exists('ok', $payload)) {
            $ok = (bool) $payload['ok'];
        } elseif (($payload['status'] ?? null) === 'ok') {
            $ok = true;
        }

        return new self($ok, $payload);
    }
}
