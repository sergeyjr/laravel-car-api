<?php

namespace App\Domain\Contact;

class Contact
{

    private int $id;
    private string $name;
    private string $email;
    private string $subject;
    private string $body;

    public function __construct(string $name, string $email, string $subject, string $body)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Создает объект из массива данных (обычно из Eloquent)
     */
    public static function fromState(array $state): self
    {
        return new self(
            name: $state['name'],
            email: $state['email'],
            subject: $state['subject'],
            body: $state['body']
        );
    }

    /**
     * Преобразует объект в массив для сохранения в БД
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'body' => $this->body,
        ];
    }

}
