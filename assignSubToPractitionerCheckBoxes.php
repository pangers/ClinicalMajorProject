<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Assign subject to practitioner - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/assignSubToPractitionerCheckBoxes.css">
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
                    $selectedPractitionerID = $_POST['practitionerRadio'];
                    $_SESSION['pracToAssignSubjects'] = $selectedPractitionerID;
                    
                    echo "<p>Select subjects to assign and click confirm.</p>";

                    //query to find subjects already assigned to selected practitioner
                    $alreadyAssignedSubjectsQuery = "SELECT SubjectID FROM PractitionerWithSub WHERE PractitionerID=".$selectedPractitionerID.";";
                    $alreadyAssignedSubjectsResults = odbc_exec($conn, $alreadyAssignedSubjectsQuery);

                    //save already assigned subjectID's into an array
                    $count = 0;
                    while(odbc_fetch_row($alreadyAssignedSubjectsResults)) {
                        $alreadyAssignedSubjectID[$count] = odbc_result($alreadyAssignedSubjectsResults, "SubjectID");
                        $count += 1;
                    }

                    //query to obtain all existing subjects
                    //obtain current practitioner details
                    $currentSubjectsQuery = "SELECT * FROM Subject;";
                    $currentSubjectsResult = odbc_exec($conn, $currentSubjectsQuery);

                    //build practitioner table dynamically
                    echo "<form method=\"post\" action=\"assignSubToPractitionerResult.php\">";
                    echo "<table><th>Subject ID</th><th>Name</th><th>Assigned Subjects</th>";
                    //while there are still records to list, make a new table row with practitioner name and username
                    while(odbc_fetch_row($currentSubjectsResult)) {
                        $subjectID = odbc_result($currentSubjectsResult, "SubjectID");
                        $subjectFirstName = odbc_result($currentSubjectsResult, "FirstName");
                        $subjectLastName = odbc_result($currentSubjectsResult, "LastName");
                        //if subjectID is already assigned, premark the checkbox, otherwise, dont premark
                        if(!empty($alreadyAssignedSubjectID) && in_array($subjectID, $alreadyAssignedSubjectID)) {
                            echo "<tr><td>".$subjectID."</td><td>".$subjectFirstName." ".$subjectLastName ."</td><td><input type=\"checkbox\" checked=\"yes\" name=\"subToPracCheckbox[]\" value=".$subjectID."></td></tr>".PHP_EOL;
                        } else {
                            echo "<tr><td>".$subjectID."</td><td>".$subjectFirstName." ".$subjectLastName ."</td><td><input type=\"checkbox\" name=\"subToPracCheckbox[]\" value=".$subjectID."></td></tr>".PHP_EOL;
                        }
                    }
                    echo "</table>";
                    echo "<br>";
                    echo "<input type=\"submit\" id=\"confirmButton\" value=\"Confirm\">";
                    echo "</form>";
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