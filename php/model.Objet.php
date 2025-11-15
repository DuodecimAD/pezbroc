<?php
namespace PEZBroc;

use Exception;
use PDO;

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Database.php';

class Objet
{
    private int $oid;
    private string $intitule;
    private string $image;
    private string $description;
    private int $cid;
    private int $bid;
    private ?PDO $dbLink;
    private string $code;
    private string $zone;
    private string $categorie;
    private string $bnom;
    private string $bprenom;

    public function __construct()
    {
        $db = new Database();
        $this->dbLink = $db->connect();

        if (!$this->dbLink) {
            throw new Exception("Database connection failed.");
        }
    }

    public function getOid(): int
    {
        return $this->oid;
    }

    public function getIntitule(): string
    {
        return $this->intitule;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCid(): int
    {
        return $this->cid;
    }

    public function getBid(): int
    {
        return $this->bid;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getZone(): string
    {
        return $this->zone;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }

    public function getBnom(): string
    {
        return $this->bnom;
    }

    public function getBprenom(): string
    {
        return $this->bprenom;
    }



    public function getObjet(int $oid): ?bool
    {
        try {
            $stmt = $this->dbLink->prepare('SELECT o.oid, o.intitule, o.image, o.description, o.cid, o.bid, 
                                                    b.nom as bnom, b.prenom as bprenom, c.intitule as categorie, e.code as code, z.nom as zone
                                                    FROM Objet o
                                                    JOIN Categorie c ON o.cid = c.cid
                                                    JOIN Brocanteur b ON o.bid = b.bid
                                                    JOIN Emplacement e ON b.eid = e.eid
                                                    JOIN Zone z ON e.zid = z.zid
                                                    WHERE oid = :oid AND o.isDeleted = 0 AND b.isDeleted = 0');
            $stmt->bindValue(':oid', $oid);
            if ($stmt->execute()) {
                $objetData = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                insertLog($stmt, $stmt->errorCode());
            }
        } catch (\Exception $e) {
            insertLog($stmt, $e->getMessage());
        }

        if ($objetData) {
            $this->mapDataToObjet($objetData);
            return true;
        }
        return false;
    }

    private function mapDataToObjet(array $data): void
    {
        $this->oid = $data['oid'];
        $this->intitule = $data['intitule'];
        $this->image = $data['image'];
        $this->description = $data['description'];
        $this->cid = $data['cid'];
        $this->bid = $data['bid'];
        $this->code = $data['code'];
        $this->zone = $data['zone'];
        $this->categorie = $data['categorie'];
        $this->bnom = $data['bnom'];
        $this->bprenom = $data['bprenom'];
    }

    public function getAllObjetsFromUser(int  $bid): array
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT * FROM Objet WHERE bid = :bid AND isDeleted = 0 ORDER BY intitule");
            $stmt->bindValue(':bid', $bid);
            $stmt->execute();
            $objetsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, 'error : ' . $e->getMessage());
        }

        if ($objetsData) {
            return $objetsData;
        }
        return [];
    }

    public function getAllObjetsFromVisibleBrocanteurs(): array
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT o.oid, o.intitule, o.image, o.description, o.cid, o.bid, b.nom as bnom, b.prenom as bprenom
                                                    FROM Objet o
                                                    JOIN Brocanteur b ON o.bid = b.bid
                                                    WHERE b.visible = 1 AND o.isDeleted = 0 AND b.isDeleted = 0
                                                    ORDER BY o.intitule");
            $stmt->execute();
            $objetsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, 'error : ' . $e->getMessage());
        }

        if ($objetsData) {
            return $objetsData;
        }
        return [];
    }

    public function get3RandomObjets(): array
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT o.oid, o.intitule, o.image 
                                                  FROM Objet o
                                                  JOIN Brocanteur b ON o.bid = b.bid
                                                  WHERE b.visible = 1 AND o.isDeleted = 0 AND b.isDeleted = 0
                                                  ORDER BY RAND() LIMIT 3;");
            $stmt->execute();
            $objetsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, 'error : ' . $e->getMessage());
        }

        if ($objetsData) {
            return $objetsData;
        }
        return [];
    }

    public function getCategories(): array
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT cid, intitule FROM Categorie");
            $stmt->execute();
            $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, 'error : ' . $e->getMessage());
        }
        if ($cats) {
            return $cats;
        }
        return [];
    }

    public function getCategorieById(string $cid): string
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT intitule FROM Categorie WHERE cid = :cid");
            $stmt->bindValue(':cid', $cid);
            $stmt->execute();
            $cat = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, 'error : ' . $e->getMessage());
        }
        if ($cat) {
            return $cat['intitule'];
        }
        return "error";
    }

    public function insertObjet(string $intitule, string $image, string $description, int $cid, int $bid): string
    {
        $error = "";
        try {
            $stmt = $this->dbLink->prepare("INSERT INTO Objet (intitule, image, description, cid, bid ) 
                                                  VALUES (:intitule, :image, :description, :cid, :bid)");

            $stmt->bindValue(':intitule', $intitule);
            $stmt->bindValue(':image', $image);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':cid', $cid);
            $stmt->bindValue(':bid', $bid);

            $stmt->execute();
            $params = ['intitule' => $intitule, 'image' => $image, 'description' => $description, 'cid' => $cid,'bid' => $bid];
            insertLog($stmt, $params);

        } catch (\Exception $e) {
            $error = $e->getMessage();
            insertLog($stmt, $e->getMessage());
        }
        return $error;
    }

    public function updateObjetWithImage(string $oid, string $intitule, string $image, string $description, int $cid): string
    {
        $error = "";
        try {
            $stmt = $this->dbLink->prepare("UPDATE Objet SET intitule = :intitule,  image = :image, description = :description, cid = :cid WHERE oid = :oid");
            $stmt->bindValue(':intitule', $intitule);
            $stmt->bindValue(':image', $image);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':cid', $cid);
            $stmt->bindValue(':oid', $oid);

            $stmt->execute();
            $params = ['intitule' => $intitule, 'image' => $image, 'description' => $description, 'cid' => $cid,'oid' => $oid];
            insertLog($stmt, $params);

        } catch (\Exception $e) {
            $error = $e->getMessage();
            insertLog($stmt, $e->getMessage());
        }
        return $error;
    }

    public function updateObjetWithoutImage(string $oid, string $intitule, string $description, int $cid): string
    {
        $error = "";
        try {
            $stmt = $this->dbLink->prepare("UPDATE Objet SET intitule = :intitule, description = :description, cid = :cid WHERE oid = :oid");
            $stmt->bindValue(':intitule', $intitule);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':cid', $cid);
            $stmt->bindValue(':oid', $oid);

            $stmt->execute();
            $params = ['intitule' => $intitule, 'description' => $description, 'cid' => $cid,'oid' => $oid];
            insertLog($stmt, $params);

        } catch (\Exception $e) {
            $error = $e->getMessage();
            insertLog($stmt, $e->getMessage());
        }
        return $error;
    }

    public function deleteObjet(String $oid): string
    {
        try {
            $stmt = $this->dbLink->prepare("UPDATE Objet SET isDeleted = 1 WHERE oid = :oid");
            $stmt->bindValue(':oid', $oid);
            $stmt->execute();

            $params = ['oid' => $oid];
            insertLog($stmt, $params);
            return "success";
        } catch (\Exception $e) {
            insertLog($stmt, $e->getMessage());
        }
        return 'fail => $oid : ' . $oid;
    }


}