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

    $sqlRequest = "INSERT INTO ip_address (ip_address, ip_type) VALUES ('$validatedIP', '$ipType')";

    if ($db->query($sqlRequest) === TRUE) {
        $response = ['status' => 'success', 'message' => 'IP address inserted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => $db->error];
    }
}

$db->close();

header('Content-Type: application/json');
echo json_encode($response);