<?php
$dbname = 'project_cpm1';

if (!$mysql = mysql_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

mysql_select_db('project_cpm1');

$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_row($result)) {
	$tables[] = $row[0];
}   
/*mysql_free_result($result);*/
//echo "<pre>";
//print_r($tables);


foreach ($tables as $table) {
$sql = "ALTER TABLE ".$table. " ADD branch_id INT";
	mysql_query($sql);

	echo mysql_error($mysql);
}

?>


