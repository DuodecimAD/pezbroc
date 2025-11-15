<?php

use PEZBroc\Database;

if (!defined('SAFE_ENTRY')) {
    header("Location: ../index.php");
    exit();
}

function nettoyage_to_db($data): string
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function nettoyage_from_db($data): string
{
    return htmlspecialchars_decode(trim($data), ENT_QUOTES);
}

function insertLog($stmt, $params = null): void
{
    $dbLink = new Database();
    $bdd = $dbLink->connect();

    if ($bdd) {
        if ($stmt instanceof \PDOStatement) {
            $query = $stmt->queryString;

            if (is_array($params)) {
                foreach ($params as $key => $value) {
                    $query = str_replace(":$key", nettoyage_to_db($value), $query);
                }
            } else {
                $query .= ' => ' . $params;
            }
        } else if (is_string($stmt) ) {
            $query = $stmt;
        }

        // adding logs to database about queries
        $logStmt = $bdd->prepare("INSERT INTO query_logs (query_text) VALUES (:query)");
        $logStmt->bindValue(':query', $query);
        $logStmt->execute();

    }

    $dbLink->disconnect($bdd);

    /*
    CREATE TABLE query_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        query_text TEXT,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    */
}

function cancelAllDeleted(): void
{
    $dbLink = new Database();
    $bdd = $dbLink->connect();

    if ($bdd) {
        try {
            $bdd->beginTransaction();
            $bdd->prepare("UPDATE Brocanteur SET isDeleted = 0")->execute();
            $bdd->prepare("UPDATE Objet SET isDeleted = 0")->execute();
            $bdd->commit();

            insertLog("cancelAllDeleted");

        } catch (Exception $e) {
            $bdd->rollBack();
            insertLog($bdd, $e->getMessage());
        }

    }
    $dbLink->disconnect($bdd);
}


//UPLOAD_ERR_OK => 'There is no error, the file uploaded successfully.',
//UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
//UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form.',
//UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
//UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
//UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
//UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
//UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',


