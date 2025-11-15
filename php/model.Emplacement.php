<?php
namespace PEZBroc;

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php/model.Database.php';

use Exception;
use PDO;

class Emplacement
{
    private int $eid;
    private string $code;
    private int $zid;
    private array $tableauEmplacements = [];
    private array $tableauZones = [];
    private ?PDO $dbLink;

    public function __construct()
    {
        $db = new Database();
        $this->dbLink = $db->connect();

        if (!$this->dbLink) {
            throw new Exception("Database connection failed.");
        }
    }

    public function getEid(): int
    {
        return $this->eid;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getZid(): int
    {
        return $this->zid;
    }

    public function getTableauEmplacements(): array
    {
        return $this->tableauEmplacements;
    }

    public function getTableauZones(): array
    {
        return $this->tableauZones;
    }


    public function getEmplacementsCount(): int
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT count(*) as count FROM Emplacement");

            $stmt->execute();
            $emplacementsCount = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, $e->getMessage());
        }

        if ($emplacementsCount) {
            return $emplacementsCount['count'];
        }
        return -1;
    }

    private function parseToArray(array $array, string $string): void
    {
        if($string === 'emplacements'){
            foreach ($array as $emplacement) {
                $this->tableauEmplacements[] = [
                    'eid' => $emplacement['eid'],
                    'code' => $emplacement['code'],
                    'zid' => $emplacement['zid']
                ];
            }
        } else if($string === 'zones'){
            foreach ($array as $zone) {
                $this->tableauZones[] = [
                    'zid' => $zone['zid'],
                    'nom' => $zone['nom'],
                    'description' => $zone['description']
                ];
            }
        }

    }

    public function getAllEmplacementsNotNull(): array
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT e.eid, e.code, e.zid FROM Emplacement e LEFT JOIN Brocanteur b ON b.eid = e.eid WHERE b.eid IS NULL");

            $stmt->execute();
            $emplacements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, $e->getMessage());
        }

        if ($emplacements) {
            $this->parseToArray($emplacements, 'emplacements');
        }
        return $this->tableauEmplacements;
    }

    public function getCodeById(int $eid): string
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT code FROM Emplacement WHERE eid = :eid");
            $stmt->bindValue(':eid', $eid);
            $stmt->execute();
            $code = $stmt->fetch(PDO::FETCH_ASSOC);
            return $code['code'];

        } catch (\Exception $e) {
            insertLog($stmt, $e->getMessage());
        }
        return 'fail => $eid: ' . $eid;
    }

    public function getZones(): array
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT zid, nom, description FROM Zone");

            $stmt->execute();
            $zones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            insertLog($stmt, $e->getMessage());
        }

        if ($zones) {
            $this->parseToArray($zones, 'zones');
        }
        return $this->tableauZones;
    }


}