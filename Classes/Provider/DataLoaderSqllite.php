<?php
declare(strict_types=1);

namespace Provider;

final class DataLoaderSqlite implements DataLoaderInterface
{
    private $data;

    private \PDO $pdo;



    public function getData(): array
    {
        return $this->data;
    }
}