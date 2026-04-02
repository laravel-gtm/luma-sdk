<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class CalendarResponse
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $slug,
        public ?string $avatarUrl,
        public ?string $url,
        public ?string $description,
        public ?string $socialImageUrl,
        public ?string $coverImageUrl,
        public ?bool $isPersonal,
        public ?string $instagramHandle,
        public ?string $twitterHandle,
        public ?string $youtubeHandle,
        public ?string $website,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            name: (string) $data['name'],
            slug: isset($data['slug']) ? (string) $data['slug'] : null,
            avatarUrl: isset($data['avatar_url']) ? (string) $data['avatar_url'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
            description: isset($data['description']) ? (string) $data['description'] : null,
            socialImageUrl: isset($data['social_image_url']) ? (string) $data['social_image_url'] : null,
            coverImageUrl: isset($data['cover_image_url']) ? (string) $data['cover_image_url'] : null,
            isPersonal: isset($data['is_personal']) ? (bool) $data['is_personal'] : null,
            instagramHandle: isset($data['instagram_handle']) ? (string) $data['instagram_handle'] : null,
            twitterHandle: isset($data['twitter_handle']) ? (string) $data['twitter_handle'] : null,
            youtubeHandle: isset($data['youtube_handle']) ? (string) $data['youtube_handle'] : null,
            website: isset($data['website']) ? (string) $data['website'] : null,
        );
    }
}
