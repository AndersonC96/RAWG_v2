<?php
/**
 * Search Controller
 * 
 * Handles game search functionality
 */

require_once __DIR__ . '/../services/api.php';

$data = [];
$searchQuery = '';

if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
    $searchQuery = trim($_POST['search']);
    $response = apiSearch($searchQuery);
    
    if ($response && isset($response->results)) {
        $data = $response->results;
    }
}