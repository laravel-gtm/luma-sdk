<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class CalendarResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $avatarUrl,
        public readonly ?string $url,
        public readonly ?string $description,
        public readonly ?string $socialImageUrl,
        public readonly ?string $coverImageUrl,
        public readonly ?bool $isPersonal,
        public readonly ?string $instagramHandle,
        public readonly ?string $twitterHandle,
        public readonly ?string $youtubeHandle,
        public readonly ?string $website,
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
