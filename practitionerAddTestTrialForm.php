<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Add a new test trial - Practitioner</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/practitionerAddTestTrialForm.css">
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
                    //retrieve and save subject chosen
                    $selectedSubjectID = $_POST['subjectRadio'];
                    $_SESSION['chosenSubjectForTestTrial'] = $selectedSubjectID;

                    echo "<p>Enter details of new test trial and click create.</p>";

                    echo "<form method=\"post\" id=\"trialForm\" onSubmit=\"return validateTestTrialForm()\" action=\"practitionerAddTestTrialResult.php\">";
                    echo "<table>";
                    echo "<tr><td>Test Date:</td><td><input type=\"text\" id=\"subBirthDate\" onChange=\"validBirthDate()\" name=\"birthDate\"></td><td id=\"birthDateError\"></td></tr>";
                    echo "<tr><td>Description:</td><td><input type=\"text\" id=\"description\" onChange=\"validDescription()\" name=\"description\"></td><td id=\"descriptionError\"></td></tr>";
                    echo "<tr><td>True Falls Risk:</td><td><input type=\"text\" id=\"trueFallsRisk\" onChange=\"validTrueFallsRisk()\" name=\"trueFallsRisk\"></td><td id=\"trueFallsRiskError\"></td></tr>";
                    echo "</table>";
                    echo "<br>";
                    echo "<input id=\"createButton\" type=\"submit\" value=\"Create\">";
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