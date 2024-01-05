<?php

use database\DatabaseConnection;

require_once __DIR__ . '/../../database/DatabaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    die(json_encode(['status' => 'error', 'message' => 'Only GET Method supported']));
}

$dbConnection = new DatabaseConnection();
$db = $dbConnection->getConnection();

if ($db->connect_error) {
    $response = ['status' => 'error', 'message' => $db->connect_error];
} else {
    $stmt = $db->prepare("SELECT ip_address.ip_address, ip_address.ip_type, ip_address.description, ip_monitoring_status.ping_status FROM ip_address LEFT JOIN ip_monitoring_status ON ip_address.id = ip_monitoring_status.ip_address_id");
    $success = $stmt->execute();

    if ($success) {
        $result = $stmt->get_result();

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $response = json_encode(['status' => 'success', 'data' => $rows]);

    } else {
        $response = json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}

$db->close();

header('Content-Type: application/json');
echo $response;