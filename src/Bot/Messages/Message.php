<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages;

use Illuminate\Support\Collection;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\AttachmentInterface;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Links\ForwardLink;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Links\ReplyLink;

class Message
{
    private ?string $text;

    private ?Collection $attachments;

    private ?ReplyLink $link;

    private bool $notify;

    private string $format;

    public const FORMAT_MARKDOWN = 'markdown';
    public const FORMAT_HTML = 'html';

    public function __construct(
        ?string $text = null,
        ?Collection $attachments = null,
        ?ReplyLink $link = null,
        bool $notify = true,
        ?string $format = self::FORMAT_MARKDOWN
    ) {
        $this->text = $text;
        $this->attachments = $attachments;
        $this->link = $link;
        $this->notify = $notify;
        $this->format = $format;
        $this->validate();
    }

    public static function message(
        ?string $text = null,
        ?Collection $attachments = null,
        ?ReplyLink $link = null,
        bool $notify = true,
        ?string $format = self::FORMAT_MARKDOWN
    ): Message {
        return new static($text, $attachments, $link, $notify, $format);
    }

    private function validate(): void
    {
        if ($this->text === null && $this->attachments->isEmpty() && $this->link === null) {
            throw new \InvalidArgumentException('Сообщение должно содержать text, attachments, или link.');
        }

        if ($this->format !== null && !in_array($this->format, ['markdown', 'html'])) {
            throw new \InvalidArgumentException('Формат должен быть "markdown" or "html".');
        }
    }

    public function notify(bool $notify = true): self
    {
        $this->notify = $notify;
        return $this;
    }

    public function addAttachment(AttachmentInterface $attachment): self
    {
        if (is_null($this->attachments)) {
            $this->attachments = new Collection();
        }
        $this->attachments->push($attachment);
        return $this;
    }

    public function setAttachments(Collection $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function setReplyTo(string $messageId): self
    {
        if (!$this->link) {
            $this->link = new ReplyLink($messageId);
        }

        $this->link->setMessageId($messageId);
        return $this;
    }

    public function setForwardFrom(string $messageId): self
    {
        if (!$this->link) {
            $this->link = new ReplyLink($messageId);
        }

        $this->link->setMessageId($messageId);
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'text' => $this->text,
            'notify' => $this->notify,
        ];

        if ($this->attachments) {
            $data['attachments'] = $this->attachments->map->toArray();
        }

        if ($this->link !== null) {
            $data['link'] = $this->link->toArray();
        }

        if ($this->format !== null) {
            $data['format'] = $this->format;
        }

        return $data;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function getLink(): ?ReplyLink
    {
        return $this->link;
    }

    public function isNotify(): bool
    {
        return $this->notify;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }
}
