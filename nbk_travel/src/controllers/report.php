<?php
/**
 * Report Controller
 */

declare(strict_types=1);

session_name('NBK_SHUTTLE_SESSION');
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../models/Report.php';

Auth::requireAuth();
Auth::checkTimeout();

header('Content-Type: application/json');

$report = new Report();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'] ?? 'dashboard';
    $startDate = $_GET['startDate'] ?? date(DATE_FORMAT, strtotime('-30 days'));
    $endDate = $_GET['endDate'] ?? getCurrentDate();
    
    if ($type === 'dashboard') {
        $result = $report->getDashboardStats();
        successResponse('Dashboard stats', $result);
    } else if ($type === 'trips') {
        $result = $report->getTripReport($startDate, $endDate);
        successResponse('Trip report', $result);
    } else if ($type === 'revenue') {
        $result = $report->getRevenueReport($startDate, $endDate);
        successResponse('Revenue report', $result);
    } else if ($type === 'topCustomers') {
        $limit = intval($_GET['limit'] ?? 10);
        $result = $report->getTopCustomersReport($limit);
        successResponse('Top customers report', $result);
    } else if ($type === 'driverUtilisation') {
        $result = $report->getDriverUtilisationReport($startDate, $endDate);
        successResponse('Driver utilisation report', $result);
    } else {
        errorResponse('Unknown report type', []);
    }
}

?>
