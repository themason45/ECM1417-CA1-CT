<?php 
$request = $_SERVER['REQUEST_URI'];
    
if (str_starts_with($request, '/report')) {
    require __DIR__ . "/report_mock.php";
} elseif (str_starts_with($request, '/infections')) {
    require __DIR__ . "/infections_mock.php";
}
