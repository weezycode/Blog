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
    private array $bd = [];

    private string $table = 'comments';

    public function __construct(
        $servername = "localhost",
        $username = "root",
        $password = "",
        $bdd = ""
    ) {
        // Create bddection

        try {
            $bdd = new PDO("mysql:host=$servername;dbname=blog", $username, $password);
            // set the PDO error mode to exception
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "bddected successfully";
        } catch (PDOException $e) {
            //echo "bddection failed: " . $e->getMessage();
        }



        // /* A retirer - Début - Ne pas analyser ce code*/
        // // table user
        // $this->bd['user']['jean@free.fr'] = ['id' => 1, 'email' => 'jean@free.fr', 'pseudo' => 'jean', 'password' => 'password'];
        // // table post
        // $this->bd['post'][1] = ['id' => 1, 'title' => 'Article $1 du blog', 'text' => 'Lorem ipsum 1'];
        // $this->bd['post'][25] = ['id' => 25, 'title' => 'Article $25 du blog', 'text' => 'Lorem ipsum 25'];
        // $this->bd['post'][26] = ['id' => 26, 'title' => 'Article $26 du blog', 'text' => 'Lorem ipsum 26'];
        // // table comment
        // $this->bd['comment'][1] = [
        //     ['id' => 1, 'pseudo' => 'Maurice', 'text' => "J'aime bien", 'idPost' => '1'],
        //     ['id' => 4, 'pseudo' => 'Eric', 'text' => 'bof !!!', 'idPost' => '1'],
        // ];
        // $this->bd['comment'][25] = [
        //     ['id' => 2, 'pseudo' => 'Marc', 'text' => 'Cool', 'idPost' => '25'],
        //     ['id' => 3, 'pseudo' => 'Jean', 'text' => "Je n'ai pas compris", 'idPost' => '25'],
        // ];
        // $this->bd['comment'][26] = null;
        /* A retirer - Fin */
    }
    public function baseDonne()
    {
        return $this->bdd;
    }

    public function getData()
    {

        $this->sq = "SELECT id_author, title, short_content,content, date_created FROM articles";

        $this->result = $this->bdd->prepare($this->sq);
        $this->result->execute();
        $this->rows = $this->result->fetchAll();


        // output data of each row
        foreach ($this->rows as $row) {
            echo "le titre: " . $row["title"] . "<br> - Contenu: " . $row["content"] . "<br> " . $row["date_created"] . "<br>";
        }

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
