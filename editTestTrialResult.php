<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Edit test trial result - Administrator</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/editTestTrialResult.css">
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
    
                    //extract details from update form
                    $date = $_POST["birthDate"];
                    $description = $_POST["description"];
                    $trueFallsRisk = $_POST["trueFallsRisk"];
                    $selectedSubjectID = $_SESSION['chosenSubjectForTestTrial'];
                    $previousDate = $_SESSION['previousTestTrialDate'];

                    //obtain existing test trials for selected subject (subjectID and dates)
                    $currenttestTrialsQuery = "SELECT SubjectID, TestDate FROM TestTrials WHERE SubjectID=$selectedSubjectID;";
                    $currenttestTrialsResult = odbc_exec($conn, $currenttestTrialsQuery);

                    //store resulting query into php array
                    $count = 0;
                    while(odbc_fetch_row($currenttestTrialsResult)) {
                        $existingTestDate[$count] = odbc_result($currenttestTrialsResult, "TestDate");
                        $count += 1;
                    }
                    
                    //check if subjectID and test date combination is unique
                    $uniqueFlag = false;
                    for ($i = 0; $i < sizeof($existingTestDate); $i++) {
                        if(!in_array($date, $existingTestDate) || ($date==$previousDate)) {
                            $uniqueFlag = true;
                        }
                    }
                    
                    //if the subjectID and test date combination is unique, then update
                    if ($uniqueFlag) {
                        //retrieve existing trial descriptions and check if new record needs to be added
                        $currentTrialsDescQuery = "SELECT Description FROM TrialDescription;";
                        $currentTrialsDescResult = odbc_exec($conn, $currentTrialsDescQuery);
                        //store resulting query into php array
                        $count = 0;
                        while(odbc_fetch_row($currentTrialsDescResult)) {
                            $existingTrialDesc[$count] = odbc_result($currentTrialsDescResult, "Description");
                            $count += 1;
                        }
                        //check if new record needs to be added. If so, add description in and obtain trial description ID
                        if(!in_array($description, $existingTrialDesc)) {
                            $insertTrialQuery = "INSERT INTO TrialDescription (Description) VALUES ('$description');";
                            $insertTrialResult = odbc_exec($conn, $insertTrialQuery);
                            $descriptionIDQuery = "SELECT DescriptionID FROM TrialDescription WHERE Description='$description';";
                            $descriptionIDResult = odbc_exec($conn, $descriptionIDQuery);
                            while(odbc_fetch_row($descriptionIDResult)) {
                                $descriptionID = odbc_result($descriptionIDResult, "DescriptionID");
                            }
                        //description already exists, get description ID for existing description
                        } else {
                            $descriptionIDQuery = "SELECT DescriptionID FROM TrialDescription WHERE Description='$description';";
                            $descriptionIDResult = odbc_exec($conn, $descriptionIDQuery);
                            while(odbc_fetch_row($descriptionIDResult)) {
                                $descriptionID = odbc_result($descriptionIDResult, "DescriptionID");
                            }
                        }
                        
                        //create query to update TestTrials table
                        $updateQuery = "UPDATE TestTrials SET TestDate='$date', DescriptionID='$descriptionID', TrueFallsRisk='$trueFallsRisk' WHERE TestDate='$previousDate' AND SubjectID=$selectedSubjectID;";
                        $updateResult = odbc_exec($conn, $updateQuery);
                        echo "<h3>Edit successful</h3>";
                        echo "<p>Test trial was updated.</p>";
                    } else {
                        echo "<h3>Edit unsuccessful</h3>";
                        echo "<p>Subject already performed test trial on that date.</p>";
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