<?php

require_once './includes/_database.php'; 
require_once './includes/_function.php';
require_once './includes/_message.php';

header('Content-Type: application/json');

// Check CSRF

try {
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($searchTerm)) {

        $results = filterTransactions($dbCo, $searchTerm, $transactions);

        if ($results !== false) {
            echo json_encode($results);
        } else {
            echo json_encode(['error' => 'Erreur lors de la récupération des données']);
        }
    } else {
        $allTransactions = fetchAllTransactions($dbCo);
        echo json_encode($allTransactions);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}