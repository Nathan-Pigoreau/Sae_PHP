<?php
declare(strict_types=1);

namespace Provider;

final class DataLoaderSqlite implements DataLoaderInterface
{
    private $data;

    private \PDO $pdo;

    private array $keys = [''];

    public function getData(): array
    {
        return $this->data;
    }

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $stmt = $pdo->query('SELECT * FROM ARTISTE');
        $content = $stmt->fetchAll();

        $this->data = array_map(function($v){
            $d = [];
            foreach ($v as $key => $value) {
                if(!in_array($key, $this->keys)) {
                    continue;
                }
                $d[$key] = $value;
                if ($key === 'choices' && $value) {
                    $d[$key] = explode(',', $value);
                }
            }
            return $d;
        }, $contents);

        if (empty($this->data)) {
            throw new \Exception(sprintf('No question in "%s"', 'sqlite'));
        }
    }
}