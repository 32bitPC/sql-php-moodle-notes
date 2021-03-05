# sql-php-moodle-notes <br>
**Create SQL username and password** <br>
- Microsoft SQL Server Management Studio <br>
- Security > Logins > New Login<br><br>
**Connect SQL Server Management Studio with PHP** <br>
Assume you already have SQL database and username : <br>
Access https://github.com/microsoft/msphpsql/releases/tag/v5.9.0 , download **Windows-7.3.zip** <br>
Put **php_sqlsrv_73_ts.dll** and **php_pdo_sqlsrv_73_ts.dll** in ext <br>
Enable **extension=php_pdo_sqlsrv_73_ts extension=php_sqlsrv_73_ts** in php.ini <br>
Follow https://www.php.net/manual/en/function.sqlsrv-connect.php to connect both PHP and SQL Server <br>
Use **print_r($row)** to print database items <br>
Use **echo $row[0]."\n".$row[1]."\n".$row[2]."\n\n";** for **SQLSRV_FETCH_NUMERIC** <br>
Use **select row_number() over (ORDER BY field_1) n from table;** to select column <br><br>

**phpmyadmin** + **moodle php** : <br>
username and password of both must be the same <br>

Use **get_record** wisely <br>
https://stackoverflow.com/questions/28460512/proper-use-of-get-records-in-moodle <br>
$record = $DB->get_record( 'table_name', array('key' => 'value'), 'selected key'); <br>
$record->selected key; <br>
