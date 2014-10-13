<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Edit Test Trial - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/editTestTrial.css">
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

                    echo "<p>Select which test trial to change and click edit.</p>";

                    //obtain current test trials
                    $currentTestTrialsQuery = "SELECT Subject.SubjectID, Subject.FirstName, Subject.LastName, TestTrials.TestDate, TrialDescription.Description, TestTrials.TrueFallsRisk FROM Subject INNER JOIN (TrialDescription INNER JOIN TestTrials ON TrialDescription.DescriptionID = TestTrials.DescriptionID) ON Subject.SubjectID = TestTrials.SubjectID;";
                    $currentTestTrialsResult = odbc_exec($conn, $currentTestTrialsQuery);

                    echo "<form method=\"post\" action=\"editTestTrialForm.php\">";
                    //build practitioner table dynamically
                    echo "<table><th>Subject ID</th><th>Name</th><th>Test Date</th><th>Description</th><th>True Falls Risk</th><th>Selection</th>";
                    //while there are still records to list, make a new table row with practitioner name and username
                    while(odbc_fetch_row($currentTestTrialsResult)) {
                        $subjectID = odbc_result($currentTestTrialsResult, "SubjectID");
                        $subjectFirstName = odbc_result($currentTestTrialsResult, "FirstName");
                        $subjectLastName = odbc_result($currentTestTrialsResult, "LastName");
                        $trialTestDate = odbc_result($currentTestTrialsResult, "TestDate");
                        $trialDescription = odbc_result($currentTestTrialsResult, "Description");
                        $trueFallsRisk = odbc_result($currentTestTrialsResult, "TrueFallsRisk");
                        echo "<tr><td>".$subjectID."</td><td>".$subjectFirstName." ".$subjectLastName ."</td><td>".$trialTestDate."</td><td>".$trialDescription."</td><td>".$trueFallsRisk."</td><td><input type=\"radio\" name=\"testTrialRadio\" value=".$subjectID."_".$trialTestDate." checked=\"checked\"></td></tr>".PHP_EOL;
                    }
                    echo "</table>";
                    echo "<br>";
                    echo "<input type=\"submit\" id=\"editButton\" name=\"submit\" value=\"Edit\">";
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