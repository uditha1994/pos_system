<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// local Database configuration
$host = 'localhost:3306';
$dbname = 'basic_pos';
$username = 'root';
$password = 'Uditha@321';

//details for infinityfree
// $host = 'sql108.infinityfree.com:3306';
// $dbname = 'if0_38714667_basic_pos';
// $username = 'if0_38714667';
// $password = 'OIH9uglWm5';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    // Test the connection immediately
    $conn->query("SELECT 1");

    // Make the connection available globally
    $pdo = $conn;

} catch (PDOException $ex) {
    // More detailed error information
    $errorInfo = [
        'message' => $ex->getMessage(),
        'code' => $ex->getCode(),
        'host' => $host,
        'dbname' => $dbname,
        'username' => $username
    ];

    error_log("Database Connection Failed: " . print_r($errorInfo, true));
    die("<h2>Database Connection Error</h2>
         <p><strong>Message:</strong> {$errorInfo['message']}</p>
         <p><strong>Database:</strong> {$errorInfo['dbname']}@{$errorInfo['host']}</p>
         <p>Please check your database configuration and try again.</p>");
}
?>