<?php
$serverName = "server_name";
$connectionInfo = array( "Database"=>"database_name");
$conn = sqlsrv_connect( $serverName, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = "SELECT name,type,color FROM tables";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
    echo $row[0]."\n".$row[1]."\n".$row[2]."\n\n";
}

sqlsrv_free_stmt( $stmt);
?>
