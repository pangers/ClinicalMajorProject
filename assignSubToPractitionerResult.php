<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Assign subject to practitioner - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/assignSubToPractitionerResult.css">
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
                    if(isset($_POST['subToPracCheckbox'])) {
                        $selectedSubjects = $_POST['subToPracCheckbox'];
                    }
                    $selectedPractitionerID = $_SESSION['pracToAssignSubjects'];

                    //query to delete all existing subjects assigned to chosen practitioner
                    $deleteOldAssignmentsQuery = "DELETE * FROM PractitionerWithSub WHERE PractitionerID=".$selectedPractitionerID.";";
                    $deleteOldAssignmentsResult = odbc_exec($conn, $deleteOldAssignmentsQuery);

                    //if at least one subject was assigned to practitioner
                    if(isset($_POST['subToPracCheckbox'])) {
                        //query to assign selected subjects to selected practitioner
                        foreach($selectedSubjects as $subjectID) {
                            $assignSelectedSubjectsQuery = "INSERT INTO PractitionerWithSub (PractitionerID, SubjectID) VALUES ('$selectedPractitionerID', '$subjectID');";
                            $assignSelectedSubjectsResult = odbc_exec($conn, $assignSelectedSubjectsQuery);
                        }
                        
                        //Query to obtain practitioner name
                        $selectedPractitionerQuery = "SELECT FirstName, LastName FROM Practitioner WHERE PractitionerID=".$selectedPractitionerID.";";
                        $selectedPractitionerResult = odbc_exec($conn, $selectedPractitionerQuery);
                        while(odbc_fetch_row($selectedPractitionerResult)) {
                                $practitionerFirstName = odbc_result($selectedPractitionerResult, "FirstName");
                                $practitionerLastName = odbc_result($selectedPractitionerResult, "LastName");
                        }
                        
                        echo "<p>The following subjects were assigned to practitioner ".$practitionerFirstName." ".$practitionerLastName."</p>";
                        
                        //query to obtain and tabulate subject details of selected subjects
                        echo "<table><th>Subject ID</th><th>Name</th><th>Birthdate</th><th>Sex</th>";
                        for ($i = 0; $i < sizeof($selectedSubjects); $i++) {
                            $selectedSubjectDetailsQuery = "SELECT * FROM Subject WHERE SubjectID=".$selectedSubjects[$i].";";
                            $selectedSubjectDetailsResult = odbc_exec($conn, $selectedSubjectDetailsQuery);

                            while(odbc_fetch_row($selectedSubjectDetailsResult)) {
                                $subjectID = odbc_result($selectedSubjectDetailsResult, "SubjectID");
                                $subjectFirstName = odbc_result($selectedSubjectDetailsResult, "FirstName");
                                $subjectLastName = odbc_result($selectedSubjectDetailsResult, "LastName");
                                $birthDate = odbc_result($selectedSubjectDetailsResult, "BirthDate");
                                $sex = odbc_result($selectedSubjectDetailsResult, "Sex");
                                echo "<tr><td>".$subjectID."</td><td>".$subjectFirstName." ".$subjectLastName."</td><td>".$birthDate."</td><td>".$sex."</td></tr>".PHP_EOL;
                            }
                        }
                        echo "</table>";
                        echo "<br>";
                       
                    //no subjects were assigned    
                    } else {
                        echo "<p>No subjects were assigned to practitioner with ID ".$selectedPractitionerID; 
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