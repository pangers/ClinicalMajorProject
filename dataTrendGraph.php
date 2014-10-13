<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Data Trend Graph - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/dataTrendGraph.css">
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

                    echo "<p>The data trend graph of subjects is shown below.</p>";

                    //retrieve existing trial data and subject birthdates, ordered by subject ID
                    $currentTrialsDataQuery = "SELECT TestTrials.SubjectID, Subject.BirthDate, TestTrials.TrueFallsRisk FROM Subject INNER JOIN TestTrials ON Subject.SubjectID = TestTrials.SubjectID ORDER BY TestTrials.SubjectID;";
                    $currentTrialsDataResult = odbc_exec($conn, $currentTrialsDataQuery);
                    //store resulting query into php array
                    $count = 0;
                    while(odbc_fetch_row($currentTrialsDataResult)) {
                        $existingSubjectID[$count] = odbc_result($currentTrialsDataResult, "SubjectID");
                        $existingBirthDate[$count] = odbc_result($currentTrialsDataResult, "BirthDate");
                        $existingTrueFallsRisk[$count] = odbc_result($currentTrialsDataResult, "TrueFallsRisk");
                        $count += 1;
                    }
                    //filter out invalid birthdates
                    $count = 0;
                    for($i=0; $i < sizeof($existingSubjectID); $i++) {
                        $existingExplodedDate = explode('/', $existingBirthDate[$i]);
                        if(($existingExplodedDate[2] < date("Y")) || (($existingExplodedDate[2] == date("Y")) && ($existingExplodedDate[1] == date("m")) && ($existingExplodedDate[0] < date("d"))) || (($existingExplodedDate[2] == date("Y")) && ($existingExplodedDate[1] < date("m")))) {
                            $validSubjectID[$count] = $existingSubjectID[$i];
                            $validBirthDate[$count] = $existingBirthDate[$i];
                            $validTrueFallsRisk[$count] = $existingTrueFallsRisk[$i];
                            $count += 1;
                        }
                    }
                    //echo "<p>Info Arrays</p>";
                    //calculate age for each element of above arrays
                    $count = 0;
                    for($i=0; $i < sizeof($validBirthDate); $i++) {
                        list($d, $m, $y) = explode('/', $validBirthDate[$i]);
                        if (($m = (date('m') - $m)) < 0) {
                            $y++;    
                        } else if ($m == 0 && date('d') - $d < 0) {
                            $y++;    
                        }
                        $age[$i] = date('Y') - $y;
                        //echo "<p>".$validSubjectID[$i]." ".$validBirthDate[$i]." ".$age[$i]." ".$validTrueFallsRisk[$i]." ".$i."</p>";
                    }
                    
                    //If a subject age has more than one falls risk data, get average of them.
                    $numOfUniqueAges = 0;
                    $Xvalues[0] = -1;
                    $Yvalues[0] = -1;
                    for ($i = 0; $i < sizeof($age); $i++) {
                        if (!in_array($age[$i], $Xvalues)) {
                            $numOfSameAgeRecords = 1;
                            $runningTotal = $validTrueFallsRisk[$i];
                            if ($i < (sizeof($age)-1)) {
                                for ($j = ($i+1); $j < sizeof($age); $j++) {
                                    if ($age[$i] == $age[$j]) {
                                        $runningTotal = $runningTotal + $validTrueFallsRisk[$j];
                                        $numOfSameAgeRecords++;
                                    }
                                }
                            }
                            $numOfUniqueAges++;
                            $Xvalues[$numOfUniqueAges-1] = $age[$i];
                            $Yvalues[$numOfUniqueAges-1] = $runningTotal/$numOfSameAgeRecords;
                        }
                    }
                    /*
                    echo "<p>Graph arrays</p>";
                    for ($i = 0; $i < sizeof($Xvalues); $i++) { 
                        echo "<p>Age is: ".$Xvalues[$i].", True Falls Risk is: ".$Yvalues[$i].", Index is: ".$i."</p>";        
                    }
                    */
                    
                    //Plotting
                    require 'RepeatedCode/DataTrendGraphing.php';
                    plotDataTrendGraph($Xvalues, $Yvalues);
                    echo "<img src=\"dataTrendGraph.png\" class=\"trendImage\"/>";
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