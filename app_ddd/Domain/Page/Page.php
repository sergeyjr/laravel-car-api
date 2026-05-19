<?php

namespace App\Domain\Page;

class Page
{

    private int $id;
    private string $code;
    private string $title;
    private string $content;
    private bool $isActive;

    public function __construct(
        string $code,
        string $title,
        string $content,
        bool   $isActive
    )
    {
        $this->code = $code;
        $this->title = $title;
        $this->content = $content;
        $this->isActive = $isActive;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Создает объект из массива данных (обычно из Eloquent)
     */
    public static function fromState(array $state): self
    {
        return new self(
            code: $state['code'],
            title: $state['title'],
            content: $state['content'],
            isActive: (bool)$state['is_active']
        );
    }

    /**
     * Преобразует объект в массив для сохранения в БД
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'content' => $this->content,
            'is_active' => $this->isActive,
        ];

    }

}
