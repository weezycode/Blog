<?php

declare(strict_types=1);

namespace App\Service;


use PDOException;

use PDO;

final class Database
{
    private PDO  $bdd;

    private string $table = '';



    public function __construct(string $servername, string $username, string $password, string $dbName)
    {
        try {
            $this->bdd = new PDO("mysql:host=$servername;dbname=$dbName;charset=utf8", $username, $password);
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        }
    }

    public function getPDO(): PDO
    {

        return $this->bdd;
    }

    public function prepare(string $sq): void
    {
        $table = explode('from', $sq);
        $table = explode('where', $table[1]);
        $this->table = trim($table[0]);
    }

    public function execute(array $criteria = null): ?array
    {
        if ($criteria !== null) {
            $criteria = array_shift($criteria);

            if (!array_key_exists($criteria, $this->bdd[$this->table])) {
                return null;
            }

            return $this->bdd[$this->table][$criteria];
        }



        return $this->bdd[$this->table];
    }
}
