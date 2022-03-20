<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\Record;

class RecordsRepository
{
    public function getByLongUrl(string $longUrl): ?Record
    {
        $connection = Connection::connect();
        $result = $connection
            ->createQueryBuilder()
            ->select('long_url', 'short_code')
            ->from('short_urls')
            ->where('long_url = ?')
            ->setParameter(0, $longUrl)
            ->executeQuery()
            ->fetchAssociative();

        if ($result) {
            return new Record($result['long_url'], $result['short_code']);
        } else return null;
    }

    public function getByShortCode(string $shortCode) :?Record
    {
        $connection = Connection::connect();
        $result = $connection
            ->createQueryBuilder()
            ->select('long_url', 'short_code')
            ->from('short_urls')
            ->where('short_code = ?')
            ->setParameter(0, $shortCode)
            ->executeQuery()
            ->fetchAssociative();

        if ($result) {
            return new Record($result['long_url'], $result['short_code']);
        } else return null;
    }

    public function store(array $attributes): Record
    {
        $connection = Connection::connect();
        $connection
            ->insert('short_urls', [
                'long_url' => $attributes['long_url'],
                'short_code' => $attributes['short_code']
            ]);
        return new Record($attributes['long_url'], $attributes['short_code']);
    }
}