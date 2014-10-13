<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>NetFall</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/loginResult.css">
</head>

<body id="bodyContainer">
    <?php
        //extract details from login form
        $username = $_POST["username"];
	    $password = $_POST["password"];
        //create access level variable
        $accessLevel = 0;

        require 'RepeatedCode/DatabaseConnection.php';

        $existFlag = false;

        //check if connection with the database was successful
        if(!$conn) {
            exit("Connection Failed: " . $conn);
        } else {
            //retrieve all existing logins
            $existQuery = "SELECT * FROM Login;";
            $existingUsers = odbc_exec($conn, $existQuery);
            
            //While records from query still exist, loop through the records
            while(odbc_fetch_row($existingUsers)) {
                //Get username, password and access level of each user
                $existingUsername = odbc_result($existingUsers, "Username");
                $existingPassword = odbc_result($existingUsers, "Password");
                $existingAccessLevel = odbc_result($existingUsers, "AccessLevelID");
                //if there is a match in the database, user exists
                if(($username == $existingUsername) && ($password == $existingPassword)) {
                    $existFlag = true;    
                    $accessLevel = $existingAccessLevel;
                }
            }
            
            echo "<div id=\"container\">";
                //if the user exists in database (with correct password)
                if($existFlag) {
                    //store username and access level for current session
                    $_SESSION['username'] = $username;
                    $_SESSION['accessLevel'] = $accessLevel;

                    echo "<div id=\"header\">";
                        echo "<h1>Login successful</h1>";
                        echo "<hr>";
                    echo "</div>";
                    if($accessLevel == 1) {
                        require 'RepeatedCode/AdminLinkBar.php';  
                    } else if($accessLevel == 2) {
                        require 'RepeatedCode/PractitionerLinkBar.php';
                    }

                    echo "<div id=\"content\">";
                        echo "<p>Welcome ".$_SESSION['username'].".</p>";
                        echo "<p>To begin, please select an option in the link bar.</p>";
                    echo "</div>";

                    require 'RepeatedCode/LogOutFooter.php';

                //if login details do not exist
                } else {
                    echo "<div id=\"header\">";
                        echo "<h1>Login failed</h1>";
                        echo "<hr>";
                    echo "</div>";
                    echo "<div id=\"content\">";
                        //alert user to login again
                        echo "<p>Please try again by clicking <a href=\"index.html\">here.</a></p>";
                        echo "<hr>";
                    echo "</div>";

                }
            
            echo "</div>";
        }
    ?>
</body>

</html>