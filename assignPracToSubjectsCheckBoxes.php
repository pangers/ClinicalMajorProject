<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Assign practitioner to subject - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/assignPracToSubjectsCheckBoxes.css">
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
                    $selectedSubjectID = $_POST['subjectRadio'];
                    $_SESSION['subToAssignPracs'] = $selectedSubjectID;
                    echo "<p>Select practitioners to assign and click confirm.</p>";

                    //query to find practitioners already assigned to selected subject
                    $alreadyAssignedPracsQuery = "SELECT PractitionerID FROM PractitionerWithSub WHERE SubjectID=".$selectedSubjectID.";";
                    $alreadyAssignedPracsResults = odbc_exec($conn, $alreadyAssignedPracsQuery);

                    //save already assigned subjectID's into an array
                    $count = 0;
                    while(odbc_fetch_row($alreadyAssignedPracsResults)) {
                        $alreadyAssignedPracID[$count] = odbc_result($alreadyAssignedPracsResults, "PractitionerID");
                        $count += 1;
                    }

                    //query to obtain all existing practitioners
                    //obtain current practitioner details
                    $currentPractitionersQuery = "SELECT * FROM Practitioner;";
                    $currentPractitionersResult = odbc_exec($conn, $currentPractitionersQuery);

                    //build practitioner table dynamically
                    echo "<form method=\"post\" action=\"assignPracToSubjectsResult.php\">";
                    echo "<table><th>Practitioner ID</th><th>Name</th><th>Assigned Practitioners</th>";
                    //while there are still records to list, make a new table row with practitioner name and username
                    while(odbc_fetch_row($currentPractitionersResult)) {
                        $practitionerID = odbc_result($currentPractitionersResult, "PractitionerID");
                        $practitionerFirstName = odbc_result($currentPractitionersResult, "FirstName");
                        $practitionerLastName = odbc_result($currentPractitionersResult, "LastName");
                        //if subjectID is already assigned, premark the checkbox, otherwise, dont premark
                        if(!empty($alreadyAssignedPracID) && in_array($practitionerID, $alreadyAssignedPracID)) {
                            echo "<tr><td>".$practitionerID."</td><td>".$practitionerFirstName." ".$practitionerLastName ."</td><td><input type=\"checkbox\" checked=\"yes\" name=\"pracToSubCheckbox[]\" value=".$practitionerID."></td></tr>".PHP_EOL;
                        } else {
                            echo "<tr><td>".$practitionerID."</td><td>".$practitionerFirstName." ".$practitionerLastName ."</td><td><input type=\"checkbox\" name=\"pracToSubCheckbox[]\" value=".$practitionerID."></td></tr>".PHP_EOL;
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