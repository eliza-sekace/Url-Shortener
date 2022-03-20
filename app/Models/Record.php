<?php
namespace App\Models;

class Record
{
    private string $longUrl;
    private string $hash;

    public function __construct(string $longUrl, string $hash)
    {
        $this->longUrl = $longUrl;
        $this->hash = $hash;
    }

    public function getLongUrl(): string
    {
        return $this->longUrl;
    }

    public function getShortCode(): string
    {
        return $this->hash;
    }

    public function createShortUrl(): string
    {
        return $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/' . $this->hash;
    }

}