<?php
    $db_server = "sql313.infinityfree.com";
    $db_user = "if0_41512858";
    $db_pass = "hKxjLDOBFqi";
    $db_name = "if0_41512858_carrentalDB";
    $conn = "";

    try {
        $conn = mysqli_connect($db_server,
                           $db_user,
                           $db_pass, 
                           $db_name);
    }
    catch (mysqli_sql_exception) {
        echo"<script>alert('not connected')</script>";
        die("Connection failed: " . $conn);
    }
    if($conn) {
        
    } 
?>