<?php
/**
 * This script is responsible for
 * establishing a connection to the
 * database.
 * 
 * @package DB Storage
 * @author  Bin Emmanuel https://github.com/binemmanuel
 * @license GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/
 * @link    https://github.com/db-storage
 *
 * @version	1.0
 */
try {
    // Enable SQL error reporting.
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Establish the connection.
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    // Set character set to UTF-8.
    $conn->set_charset('utf8mb4');
} catch (\mysqli_sql_exception  $e) {
    throw new \mysqli_sql_exception($e->getMessage(), $e->getCode()); // Throw error message.
}
