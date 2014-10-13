<?php
    //create a connection with the database
    //$conn = odbc_connect('z3333504', '', '', SQL_CUR_USE_ODBC);
    $databasePath = 'C:\xampp\htdocs\MajorProject\project.mdb';
    $conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$databasePath", "", "");
?>