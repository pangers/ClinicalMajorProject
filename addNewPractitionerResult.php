<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Insert result - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/addNewPractitionerResult.css">
    <link rel="stylesheet" type="text/css" href="css/twoColPage.css">
</head>

<body id="bodyContainer">
    <div id="container">
        <?php
            require 'RepeatedCode/PractitionerHeader.php';

            require 'RepeatedCode/AdminLinkBar.php';

            require 'RepeatedCode/AdminPractitionerSidebar.php';

            require 'RepeatedCode/DatabaseConnection.php';

            echo "<div id=\"twoColContent\">";
                //ensure person has logged in
                if(isset($_SESSION['username'])) {
                    
                    //extract details from update form
                    $firstName = $_POST["firstName"];   
                    $lastName = $_POST["lastName"];
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    //obtain list of existing usernames
                    $usernameListQuery = "SELECT Login.Username FROM Login;";
                    $usernameListResult = odbc_exec($conn, $usernameListQuery);
                    $count = 0;
                    while(odbc_fetch_row($usernameListResult)) {
                        $usernameList[$count] = odbc_result($usernameListResult, "Username");
                        $count += 1;
                    }

                    //check if username entered already exists
                    $usernameExistFlag = false;
                    for ($i = 0; $i < sizeof($usernameList); $i++) {
                        if (strtolower($username) == strtolower($usernameList[$i])) {
                            $usernameExistFlag = true;    
                        }
                    }
                    //if username already exists, dont update
                    if($usernameExistFlag) {
                        echo "<h3>Add unsuccessful</h3>";
                        echo "<p>The username ".$username." already exists.</p>";
                    //update practitioner details    
                    } else {
                        //create query to update practitioner table
                        $insertQuery = "INSERT INTO Practitioner (FirstName, LastName, Username) VALUES ('$firstName', '$lastName', '$username');";
                        $usernameListResult = odbc_exec($conn, $insertQuery);
                        //create query to update login table
                        $insertQuery = "INSERT INTO Login (Username, Password, AccessLevelID) VALUES ('$username', '$password', '2');";
                        $usernameListResult = odbc_exec($conn, $insertQuery);
                        
                        echo "<h3>Add successful</h3>";
                        echo "<p>Practitioner added to database.</p>";
                    }
                //if user came directly to page, without logging in, deny
                } else {
                    echo "<h3>You have not logged in</h3>";
                }
            echo "</div>";

            require 'RepeatedCode/LogOutFooter.php';

            
        ?>
    </div>
</body>

</html>