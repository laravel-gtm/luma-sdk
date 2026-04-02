<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\ApprovalStatus;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

readonly class GuestResponse
{
    /**
     * @param  EventTicketResponse[]  $eventTickets
     * @param  EventTicketOrderResponse[]  $eventTicketOrders
     * @param  array<mixed>  $registrationAnswers
     */
    public function __construct(
        public string $id,
        public ?string $userId,
        public ?string $userEmail,
        public ?string $userName,
        public ?string $userFirstName,
        public ?string $userLastName,
        public ApprovalStatus $approvalStatus,
        public ?string $checkInQrCode,
        public ?string $ethAddress,
        public ?LumaDate $invitedAt,
        public ?LumaDate $joinedAt,
        public ?string $phoneNumber,
        public ?LumaDate $registeredAt,
        public array $registrationAnswers,
        public ?string $solanaAddress,
        public ?string $utmSource,
        public ?string $customSource,
        public array $eventTickets,
        public ?EventTicketResponse $eventTicket,
        public array $eventTicketOrders,
        public ?string $apiId,
        public ?string $userApiId,
        public ?LumaDate $checkedInAt,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            userId: isset($data['user_id']) ? (string) $data['user_id'] : null,
            userEmail: isset($data['user_email']) ? (string) $data['user_email'] : null,
            userName: isset($data['user_name']) ? (string) $data['user_name'] : null,
            userFirstName: isset($data['user_first_name']) ? (string) $data['user_first_name'] : null,
            userLastName: isset($data['user_last_name']) ? (string) $data['user_last_name'] : null,
            approvalStatus: ApprovalStatus::from((string) $data['approval_status']),
            checkInQrCode: isset($data['check_in_qr_code']) ? (string) $data['check_in_qr_code'] : null,
            ethAddress: isset($data['eth_address']) ? (string) $data['eth_address'] : null,
            invitedAt: isset($data['invited_at']) ? LumaDate::fromString((string) $data['invited_at']) : null,
            joinedAt: isset($data['joined_at']) ? LumaDate::fromString((string) $data['joined_at']) : null,
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            registeredAt: isset($data['registered_at']) ? LumaDate::fromString((string) $data['registered_at']) : null,
            registrationAnswers: (array) ($data['registration_answers'] ?? []),
            solanaAddress: isset($data['solana_address']) ? (string) $data['solana_address'] : null,
            utmSource: isset($data['utm_source']) ? (string) $data['utm_source'] : null,
            customSource: isset($data['custom_source']) ? (string) $data['custom_source'] : null,
            eventTickets: array_map(
                EventTicketResponse::fromArray(...),
                (array) ($data['event_tickets'] ?? []),
            ),
            eventTicket: isset($data['event_ticket']) ? EventTicketResponse::fromArray((array) $data['event_ticket']) : null,
            eventTicketOrders: array_map(
                EventTicketOrderResponse::fromArray(...),
                (array) ($data['event_ticket_orders'] ?? []),
            ),
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
            userApiId: isset($data['user_api_id']) ? (string) $data['user_api_id'] : null,
            checkedInAt: isset($data['checked_in_at']) ? LumaDate::fromString((string) $data['checked_in_at']) : null,
        );
    }
}
