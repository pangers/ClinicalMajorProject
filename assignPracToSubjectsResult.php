<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Assign practitioner to subject - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/assignPracToSubjectResult.css">
    <link rel="stylesheet" type="text/css" href="css/twoColPage.css">
</head>

<body id="bodyContainer">
    <div id="container">
        <?php

            require 'RepeatedCode/SubjectHeader.php';

            require 'RepeatedCode/AdminLinkBar.php';

            require 'RepeatedCode/AdminSubjectSidebar.php';

            require 'RepeatedCode/DatabaseConnection.php';

            echo "<div id=\"twoColContent\">";

                //ensure person has logged in
                if(isset($_SESSION['username'])) {
                    if(isset($_POST['pracToSubCheckbox'])) {
                        $selectedPractitioners = $_POST['pracToSubCheckbox'];
                    }
                    $selectedSubjectID = $_SESSION['subToAssignPracs'];

                    //query to delete all existing practitioners assigned to chosen subject
                    $deleteOldAssignmentsQuery = "DELETE * FROM PractitionerWithSub WHERE SubjectID=".$selectedSubjectID.";";
                    $deleteOldAssignmentsResult = odbc_exec($conn, $deleteOldAssignmentsQuery);

                    //if at least one subject was assigned to practitioner
                    if(isset($_POST['pracToSubCheckbox'])) {
                        //query to assign selected subjects to selected practitioner
                        foreach($selectedPractitioners as $practitionerID) {
                            $assignSelectedSubjectsQuery = "INSERT INTO PractitionerWithSub (SubjectID, PractitionerID) VALUES ('$selectedSubjectID', '$practitionerID');";
                            $assignSelectedSubjectsResult = odbc_exec($conn, $assignSelectedSubjectsQuery);
                        }
                        
                        //Query to obtain subject name
                        $selectedSubjectQuery = "SELECT FirstName, LastName FROM Subject WHERE SubjectID=".$selectedSubjectID.";";
                        $selectedSubjectResult = odbc_exec($conn, $selectedSubjectQuery);
                        while(odbc_fetch_row($selectedSubjectResult)) {
                                $subjectFirstName = odbc_result($selectedSubjectResult, "FirstName");
                                $subjectLastName = odbc_result($selectedSubjectResult, "LastName");
                        }
                        
                        echo "<p>The following practitioners were assigned to subject ".$subjectFirstName." ".$subjectLastName.".</p>";
                        
                        //query to obtain and tabulate practitioner details of selected practitioners
                        echo "<table><th>Practitioner ID</th><th>Name</th><th>Username</th>";
                        for ($i = 0; $i < sizeof($selectedPractitioners); $i++) {
                            $selectedPractitionerDetailsQuery = "SELECT * FROM Practitioner WHERE PractitionerID=".$selectedPractitioners[$i].";";
                            $selectedPractitionerDetailsResults = odbc_exec($conn, $selectedPractitionerDetailsQuery);

                            while(odbc_fetch_row($selectedPractitionerDetailsResults)) {
                                $practitionerID = odbc_result($selectedPractitionerDetailsResults, "PractitionerID");
                                $practitionerFirstName = odbc_result($selectedPractitionerDetailsResults, "FirstName");
                                $practitionerLastName = odbc_result($selectedPractitionerDetailsResults, "LastName");
                                $username = odbc_result($selectedPractitionerDetailsResults, "Username");
                                echo "<tr><td>".$practitionerID."</td><td>".$practitionerFirstName." ".$practitionerLastName."</td><td>".$username."</td></tr>".PHP_EOL;
                            }
                        }
                        echo "</table>";
                        echo "<br>";
                       
                    //no subjects were assigned    
                    } else {
                        echo "<p>No practitioners were assigned to subject with ID ".$selectedSubjectID."</p>"; 
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