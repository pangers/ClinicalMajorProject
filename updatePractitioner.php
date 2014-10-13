<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Update Practitioners - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/updatePractitioner.css">
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
                echo "<p>Choose which practitioner you would like to update and click edit.</p>".PHP_EOL;

                //obtain current practitioner details
                $currentPractitionersQuery = "SELECT * FROM Practitioner INNER JOIN Login ON Practitioner.Username = Login.Username;";
                $currentPractitionersResult = odbc_exec($conn, $currentPractitionersQuery);

                echo "<form method=\"post\" action=\"updatePractitionerEdit.php\">";
                //build practitioner table dynamically
                echo "<table><th>Practitioner ID</th><th>Name</th><th>Username</th><th>Password</th><th>Selection</th>";
                //while there are still records to list, make a new table row with practitioner name and username
                while(odbc_fetch_row($currentPractitionersResult)) {
                    $practitionerID = odbc_result($currentPractitionersResult, "PractitionerID");
                    $practitionerFirstName = odbc_result($currentPractitionersResult, "FirstName");
                    $practitionerLastName = odbc_result($currentPractitionersResult, "LastName");
                    $practitionerUsername = odbc_result($currentPractitionersResult, "Username");
                    $practitionerPassword = odbc_result($currentPractitionersResult, "Password");
                    echo "<tr><td>".$practitionerID."</td><td>".$practitionerFirstName." ".$practitionerLastName ."</td><td>".$practitionerUsername."</td><td>".$practitionerPassword."</td><td><input type=\"radio\" name=\"practitionerRadio\" value=".$practitionerID." checked=\"checked\"></td></tr>".PHP_EOL;
                }
                echo "</table>";
                echo "<br>";
                echo "<input type=\"submit\" id=\"editButton\" name=\"submit\" value=\"Edit\">";
                echo "<br>";
                echo "</form>";
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