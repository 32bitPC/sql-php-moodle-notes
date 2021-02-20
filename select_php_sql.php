<?php
$serverName = "server_name";
$connectionInfo = array( "Database"=>"database_name");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = "INSERT INTO table (field_1, field_2, field_3) VALUES (?, ?, ?)";
$params = array("data_1","data_2", "data_3");

$stmt = sqlsrv_query( $conn, $sql, $params);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}
?>
