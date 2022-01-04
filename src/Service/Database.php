<?php

declare(strict_types=1);

// class pour gérer la bddection à la base de donnée
namespace App\Service;

use mysqli;
use PDOException;

use PDO;


// *** exemple fictif d'accès à la base de données
final class Database
{
    private PDO $bdd;

    private string $table = 'comments';

    public function __construct(
        $servername = "localhost",
        $username = "root",
        $password = ""
    ) {
        // Create bddection

        try {
            $this->bdd = new PDO("mysql:host=$servername;dbname=blog", $username, $password);
            // set the PDO error mode to exception
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "bddected successfully";
        } catch (PDOException $e) {
            //echo "bddection failed: " . $e->getMessage();
        }
    }


    public function getPDO(): PDO
    {

        return $this->bdd;

        // $this->sq = "SELECT id_author, title, short_content,content, date_created FROM articles";

        // $this->result = $this->bdd->prepare($this->sq);
        // $this->result->execute();
        // $this->rows = $this->result->fetchAll();


        // // output data of each row
        // foreach ($this->rows as $row) {
        //     echo "le titre: " . $row["title"] . "<br> - Contenu: " . $row["content"] . "<br> " . $row["date_created"] . "<br>";
        //}

        //return $this->bdd;
    }

    /* A retirer - Début - Ne pas analyser ce code */
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


    /* A retirer - Fin */
}
