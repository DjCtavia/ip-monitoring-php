<?php

namespace Api\Ip;

use Database\DatabaseConnection;
use Validator\IpValidator;

require_once __DIR__ . '/../../Database/DatabaseConnection.php';
require_once __DIR__ . '/../../Validator/IpValidator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['status' => 'error', 'message' => 'Only POST Method supported']));
}

$dbConnection = new DatabaseConnection();
$db = $dbConnection->getConnection();

if ($db->connect_error) {
    $response = ['status' => 'error', 'message' => $db->connect_error];
} else {
    $jsonInput = file_get_contents("php://input");

    $jsonData = json_decode($jsonInput, true);

    if (isset($jsonData['ip'])) {
        $ipToAdd = new IpValidator($jsonData['ip']);
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
            if ($e->getCode() == 1062) {
                $response = ['status' => 'error', 'message' => 'Duplicate entry for IP address'];
            } else {
                $response = ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid request. Missing IP address.'];
    }
}

$db->close();

header('Content-Type: application/json');
echo json_encode($response);