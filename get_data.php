<?php

# Static urls
$wsdl = "http://test.analitica.com.co/AZDigital_Pruebas/WebServices/ServiciosAZDigital.wsdl";
$end_point = "http://test.analitica.com.co/AZDigital_Pruebas/WebServices/SOAP/index.php";

# Set up
$client = new SoapClient($wsdl);
$client->__setLocation($end_point);

# Fetch file names
$condiciones["Condiciones"]["Condicion"] = array("Tipo"      => "FechaInicial",
                                                 "Expresion" => "2019-07-01 00:00:00");
$result = $client->BuscarArchivo($condiciones);
echo "Message Ok \n";

# Database config
$db = new SQLite3('myDatabase.sqlite');

$db->exec("CREATE TABLE IF NOT EXISTS informacion(
                id INTEGER PRIMARY KEY, 
                nombre TEXT)");
                
$db->exec("CREATE TABLE IF NOT EXISTS tipo_de_archivo(
                id INTEGER PRIMARY KEY, 
                tipo TEXT, 
                extension TEXT,
                FOREIGN KEY (id)
                    REFERENCES informacion (id))");

# Save to database
$type_dict = array("pdf"    => "Text",  
                   "docx"   => "Text", 
                   "txt"    => "Text", 
                   "xml"    => "Markup",
                   "azhtml" => "Markup",
                   "png"    => "Picture", 
                   "xls"    => "Spreadsheet",
                   "p12"    => "other");
foreach($result->Archivo as $file){
    $id = $file->Id;
    $name = $file->Nombre;
    
    $splitted_name = explode(".", $name);
    $extension = end($splitted_name);
    $type = $type_dict[$extension];
    
    $stm = $db->prepare("INSERT INTO informacion(id, nombre) VALUES(?, ?)");
    $stm->bindValue(1, $id, SQLITE3_INTEGER);
    $stm->bindValue(2, $name, SQLITE3_TEXT);
    $stm->execute();
    
    $stm = $db->prepare("INSERT INTO tipo_de_archivo(id, tipo, extension) VALUES(?, ?, ?)");
    $stm->bindValue(1, $id, SQLITE3_INTEGER);
    $stm->bindValue(2, $type, SQLITE3_TEXT);
    $stm->bindValue(3, $extension, SQLITE3_TEXT);
    $stm->execute();
}
echo "Database Ok \n";

?>
