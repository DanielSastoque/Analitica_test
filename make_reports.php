<?php

# Database config
$db = new SQLite3('myDatabase.sqlite');

# All info report
$res = $db->query(
    'SELECT * FROM informacion JOIN tipo_de_archivo ON informacion.id = tipo_de_archivo.id');

$file = fopen('all_info_report.csv', 'wb');
fputcsv($file, array('Id', 'Nombre', 'Tipo', 'Extension'));
while ( $row = $res->fetchArray() ){
    $val = array($row['id'], $row['nombre'], $row['tipo'], $row['extension']);
    fputcsv($file, $val);
}
fclose($file);

# Group report
$res = $db->query(
    'SELECT * FROM (
        SELECT extension, COUNT(extension) as cantidad 
        FROM tipo_de_archivo GROUP BY extension) ORDER BY cantidad DESC');

$file = fopen('group_report.csv', 'wb');
fputcsv($file, array('Extension', 'Cantidad'));
while ( $row = $res->fetchArray() ){
    echo "{$row['extension']} {$row['cantidad']} \n";
    $val = array($row['extension'], $row['cantidad']);
    fputcsv($file, $val);
}
fclose($file);

?>
