<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Edit trial test - Practitioner</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/practitionerEditTestTrialForm.css">
    <link rel="stylesheet" type="text/css" href="css/twoColPage.css">
</head>

<body id="bodyContainer">
    <div id="container">
        <?php

            require 'RepeatedCode/SubjectHeader.php';

            require 'RepeatedCode/PractitionerLinkBar.php';

            require 'RepeatedCode/PractitionerSubjectSidebar.php';

            require 'RepeatedCode/DatabaseConnection.php';

            echo "<div id=\"twoColContent\">";

                //ensure person has logged in
                if(isset($_SESSION['username'])) {
                    $selectedTestTrialInfo = $_POST['testTrialRadio'];
                    $selectedTestTrialValues = explode('_', $selectedTestTrialInfo);
                    $selectedTestTrialSubjectID = $selectedTestTrialValues[0];
                    $selectedTestTrialTestDate = $selectedTestTrialValues[1];
                    $_SESSION['chosenSubjectForTestTrial'] = $selectedTestTrialSubjectID;
                    $_SESSION['previousTestTrialDate'] = $selectedTestTrialTestDate;
                    
                    //$_SESSION['updateSubjectID'] = $selectedSubjectID;
                    echo "<p>Make changes to test trial details and click update.</p>";

                    //obtain selected test trial details
                    $testTrialDetailsQuery = "SELECT * FROM TestTrials INNER JOIN TrialDescription ON TestTrials.DescriptionID=TrialDescription.DescriptionID WHERE SubjectID=$selectedTestTrialSubjectID AND TestDate='$selectedTestTrialTestDate';";
                    $testTrialDetailsResult = odbc_exec($conn, $testTrialDetailsQuery);
                    while(odbc_fetch_row($testTrialDetailsResult)) {
                        $testTrialDescription = odbc_result($testTrialDetailsResult, "Description");
                        $trueFallsRisk = odbc_result($testTrialDetailsResult, "TrueFallsRisk");
                    }

                    echo "<form method=\"post\" id=\"updateForm\" onSubmit=\"return validateForm()\" action=\"practitionerEditTestTrialResult.php\">";
                    echo "<table>";
                    echo "<tr><td>Test Date:</td><td><input type=\"text\" id=\"subBirthDate\" value=".$selectedTestTrialTestDate." onChange=\"validBirthDate()\" name=\"birthDate\"></td><td id=\"birthDateError\">OK!</td></tr>";
                    echo "<tr><td>Description:</td><td><input type=\"text\" id=\"description\" value=".$testTrialDescription." onChange=\"validDescription()\" name=\"description\"></td><td id=\"descriptionError\">OK!</td></tr>";
                    echo "<tr><td>True Falls Risk:</td><td><input type=\"text\" id=\"trueFallsRisk\" value=".$trueFallsRisk." onChange=\"validTrueFallsRisk()\" name=\"trueFallsRisk\"></td><td id=\"trueFallsRiskError\">OK!</td></tr>";
                    echo "</table>";

                    echo "<br>";
                    echo "<input id=\"updateNow\" id=\"updateButton\" type=\"submit\" value=\"Update\">";
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