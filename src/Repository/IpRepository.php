<?php

namespace Repository;
require_once __DIR__ . '/../database/DatabaseConnection.php';

use database\DatabaseConnection;
use mysqli;

class IpRepository
{
    private mysqli $db;

    public function __construct()
    {
        $dbConnection = new DatabaseConnection();
        $this->db = $dbConnection->getConnection();
    }

    public function getIPList(int $limit = 10, int $offset = 0): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM ip_address INNER JOIN(SELECT id FROM ip_address LIMIT ? OFFSET ?) AS tmp USING (id) ORDER BY id");
        if (!$stmt) return null;

        $offset *= $limit;
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) return null;

        $ipList = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $ipList;
    }
}