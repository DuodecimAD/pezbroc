<?php
namespace PEZBroc;

use PDO;
use PDOException;

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/config.php';
class Database
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;

    /**
     * Permet de créer un objet de connexion avec champs par défaut, mais
     * permet aussi de créer un objet de connexion à une autre db si arguments fournis.
     *
     * @param string $host adresse ip de la db
     * @param string $user nom d'utilisateur
     * @param string $pass mot de passe de l'utilisateur
     * @param string $dbname database de l'utilisateur
     */
    public function __construct(string $host = MYHOST, string $user = MYUSER, string $pass = MYPASS, string $dbname = MYDB)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    /**
     * Se connecte à la db.
     *
     * @return PDO|null retourne un objet PDO si succès, sinon retourne null.
     */
    public function connect(): ?PDO
    {
        try {
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Déconnexion de la base de données.
     *
     * ?PDO permet d'accepter null pour éviter un message d'erreur inutile.
     *
     */
    public function disconnect(?PDO &$pdo): void
    {
        $pdo = null;
    }
}
