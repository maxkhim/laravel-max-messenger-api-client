<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class ContactAttachment implements AttachmentInterface
{
    /** @var string */
    private string $name;

    /** @var ?int|null */
    private ?int $contactId;

    /** @var string|null */
    private ?string $vcfInfo;

    /** @var string|null */
    private ?string $vcfPhone;

    public function __construct(
        string $name,
        ?int $contactId = null,
        ?string $vcfInfo = null,
        ?string $vcfPhone = null
    ) {
        $this->name = $name;
        $this->contactId = $contactId;
        $this->vcfInfo = $vcfInfo;
        $this->vcfPhone = $vcfPhone;
    }

    public function toArray(): array
    {
        $payload = ['name' => $this->name];

        if ($this->contactId !== null) {
            $payload['contact_id'] = $this->contactId;
        }
        if ($this->vcfInfo !== null) {
            $payload['vcf_info'] = $this->vcfInfo;
        }
        if ($this->vcfPhone !== null) {
            $payload['vcf_phone'] = $this->vcfPhone;
        }

        return [
            'type' => 'contact',
            'payload' => $payload,
        ];
    }
}
