<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Practitioners - Admin Mode</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/adminPractitioner.css">
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
                //obtain current practitioner details
                $currentPractitionersQuery = "SELECT * FROM Practitioner INNER JOIN Login ON Practitioner.Username = Login.Username;";
                $currentPractitionersResult = odbc_exec($conn, $currentPractitionersQuery);

                //build practitioner table dynamically
                echo "<p>The list of currently registered practitioners are shown below.</p>";
                echo "<table><th>Practitioner ID</th><th>Name</th><th>Username</th><th>Password</th>";
                //while there are still records to list, make a new table row with practitioner name and username
                while(odbc_fetch_row($currentPractitionersResult)) {
                    $practitionerID = odbc_result($currentPractitionersResult, "PractitionerID");
                    $practitionerFirstName = odbc_result($currentPractitionersResult, "FirstName");
                    $practitionerLastName = odbc_result($currentPractitionersResult, "LastName");
                    $practitionerUsername = odbc_result($currentPractitionersResult, "Username");
                    $practitionerPassword = odbc_result($currentPractitionersResult, "Password");
                    echo "<tr><td>".$practitionerID."</td><td>".$practitionerFirstName." ".$practitionerLastName ."</td><td>".$practitionerUsername."</td><td>".$practitionerPassword."</td></tr>".PHP_EOL;
                }
                echo "</table>";
                echo "<br>";
                echo "<hr>";
                echo "<p>The list of practitioners currently assigned to subjects are shown below.</p>";
                //obtain subjects assigned to practitioners in practitionerID ascending order
                $currentPractitionersWithSubs = "SELECT p.PractitionerID AS pID, p.FirstName AS pFN, p.LastName AS pLN, s.FirstName AS sFN, s.LastName AS sLN FROM Subject AS s INNER JOIN (PractitionerWithSub INNER JOIN Practitioner AS p ON PractitionerWithSub.PractitionerID = p.PractitionerID) ON s.SubjectID = PractitionerWithSub.SubjectID ORDER BY p.practitionerID ASC;";
                $currentPractitionersResult = odbc_exec($conn, $currentPractitionersWithSubs);

                //keep track of previous record practitioner
                $lastPractitionerID = 0;
                //build table dynamically
                echo "<table><th>Practitioner Name</th><th>Subject Name</th>";
                while(odbc_fetch_row($currentPractitionersResult)) {
                    $practitionerID = odbc_result($currentPractitionersResult, "pID");
                    $practitionerFirstName = odbc_result($currentPractitionersResult, "pFN");
                    $practitionerLastName = odbc_result($currentPractitionersResult, "pLN");
                    $subjectFirstName = odbc_result($currentPractitionersResult, "sFN");
                    $subjectLastName = odbc_result($currentPractitionersResult, "sLN");
                    //if query record is not same practitioner as last record
                    if($practitionerID != $lastPractitionerID) {
                        echo "<tr><td>".$practitionerFirstName." ".$practitionerLastName."</td><td>".$subjectFirstName." ".$subjectLastName."</td></tr>".PHP_EOL;
                    //if query record is same practitioner as last record
                    } else {
                        echo "<tr><td></td><td>".$subjectFirstName." ".$subjectLastName."</td></tr>".PHP_EOL;
                    }
                    //update last practitioner update before reading new record
                    $lastPractitionerID = $practitionerID;
                }
                echo "</table>";
                echo "<br>";
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