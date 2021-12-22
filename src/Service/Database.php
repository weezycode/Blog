<?php

declare(strict_types=1);

// class pour gérer la connection à la base de donnée
namespace App\Service;

use mysqli;

// *** exemple fictif d'accès à la base de données
final class Database
{
    private array $bd = [];
    private string $table = '';

    public function __construct(
        $servername = "localhost",
        $username = "root",
        $password = "",
        $dbname = "blog"
    ) {
        // Create bddection
        $this->bdd = new mysqli($servername, $username, $password, $dbname);

        // Check bddection
        if ($this->bdd->connect_error) {
            die("connection failed: " . $this->bdd->connect_error);
        }
        echo "connected successfully <br>";


        /* A retirer - Début - Ne pas analyser ce code*/
        // table user
        $this->bd['user']['jean@free.fr'] = ['id' => 1, 'email' => 'jean@free.fr', 'pseudo' => 'jean', 'password' => 'password'];
        // table post
        $this->bd['post'][1] = ['id' => 1, 'title' => 'Article $1 du blog', 'text' => 'Lorem ipsum 1'];
        $this->bd['post'][25] = ['id' => 25, 'title' => 'Article $25 du blog', 'text' => 'Lorem ipsum 25'];
        $this->bd['post'][26] = ['id' => 26, 'title' => 'Article $26 du blog', 'text' => 'Lorem ipsum 26'];
        // table comment
        $this->bd['comment'][1] = [
            ['id' => 1, 'pseudo' => 'Maurice', 'text' => "J'aime bien", 'idPost' => '1'],
            ['id' => 4, 'pseudo' => 'Eric', 'text' => 'bof !!!', 'idPost' => '1'],
        ];
        $this->bd['comment'][25] = [
            ['id' => 2, 'pseudo' => 'Marc', 'text' => 'Cool', 'idPost' => '25'],
            ['id' => 3, 'pseudo' => 'Jean', 'text' => "Je n'ai pas compris", 'idPost' => '25'],
        ];
        $this->bd['comment'][26] = null;
        /* A retirer - Fin */
    }
    public function getData()
    {
        $sql = "SELECT id_author, title, short_content,content, date_created FROM articles";
        $result = $this->bdd->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "le titre: " . $row["title"] . "<br> - Contenu: " . $row["content"] . "<br> " . $row["date_created"] . "<br>";
            }
        } else {
            echo "0 results";
        }
        return $this->bdd->close();
    }

    /* A retirer - Début - Ne pas analyser ce code */
    public function prepare(string $sql): void
    {
        $table = explode('from', $sql);
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
            return $this->bd[$this->table][$criteria];
        }

        return $this->bd[$this->table];
    }


    /* A retirer - Fin */
}
