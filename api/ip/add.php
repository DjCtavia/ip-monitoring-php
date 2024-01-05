<?php

use database\DatabaseConnection;
use utils\IPValidator;

require_once __DIR__ . '/../../database/DatabaseConnection.php';
require_once __DIR__ . '/../../utils/IPValidator.php';

$dbConnection = new DatabaseConnection();
$db = $dbConnection->getConnection();

if ($db->connect_error) {
    $response = ['status' => 'error', 'message' => $db->connect_error];
} else {
    $ipToAdd = new IPValidator($_POST['ip']);
    $validatedIP = $db->real_escape_string($ipToAdd->getIP());
    $ipType = $ipToAdd->getIPTypeString();

    try {
        $stmt = $db->prepare("INSERT INTO ip_address (ip_address, ip_type) VALUES (?, ?)");
        $stmt->bind_param("ss", $validatedIP, $ipType);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            $response = ['status' => 'success', 'message' => 'IP address inserted successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error inserting IP address'];
        }
    } catch (\Exception $e) {
        // Check for a unique constraint violation error (code 1062 in MySQL)
        if ($e->getCode() == 1062) {
            $response = ['status' => 'error', 'message' => 'Duplicate entry for IP address'];
        } else {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

$db->close();

header('Content-Type: application/json');
echo json_encode($response);