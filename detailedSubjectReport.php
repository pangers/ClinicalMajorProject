<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Detailed Report - Practitioner</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/detailedSubjectReport.css">
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
                //retrieve subject ID
                $subjectID = $_POST['subjectID'];
                
                //query to obtain subject name
                $subjectNameQuery = "SELECT FirstName, LastName FROM Subject WHERE SubjectID=$subjectID;";
                $subjectNameResult = odbc_exec($conn, $subjectNameQuery);
                while(odbc_fetch_row($subjectNameResult)) {
                    $subjectFirstName = odbc_result($subjectNameResult, "FirstName");
                    $subjectLastName = odbc_result($subjectNameResult, "LastName");
                }

                echo "<br>";
                echo "<h1>Detailed reports for ".$subjectFirstName." ".$subjectLastName."</h1>";
                
                //query to obtain all of a subjects triax data
                $triaxDataQuery = "SELECT * FROM TriaxData WHERE SubjectID=$subjectID;";
                $triaxDataResult = odbc_exec($conn, $triaxDataQuery);
                //store data
                $count = 0;
                while(odbc_fetch_row($triaxDataResult)) {
                    $DateArray[$count] = odbc_result($triaxDataResult, "Date");
                    $SigTypeArray[$count] = odbc_result($triaxDataResult, "SigTypeID");
                    $DataArray[$count] = odbc_result($triaxDataResult, "Data");
                    $count++;
                }
                $lastDate = 0;
                for ($j = 0; $j < sizeof($DateArray); $j++) {
                    //Obtain X and Y values for markers for this particular triax test (on this date), if it exists
                    for ($i = 0; $i < sizeof($DateArray); $i++) {
                        if (($DateArray[$i] == $DateArray[$j]) && ($SigTypeArray[$i] == 4)) {
                            $markerXvaluesUnexploded = $DataArray[$i];
                            $markerXvaluesExploded = explode(" ", $markerXvaluesUnexploded);
                            for ($x = 0; $x < sizeof($markerXvaluesExploded)-1; $x++) {
                                $markerTimes[$x] = ($markerXvaluesExploded[$x]*25)/1000;
                                //echo $markerTimes[$x]."<br>";
                            }
                        }
                    }
                    //for a triax test on a new date
                    if($DateArray[$j] != $lastDate) {
                        
                        echo "<hr>";
                        echo "<h2>Data for triax test on ".$DateArray[$j]."</h2>";
                        
                        require 'RepeatedCode/DetailedSubjectGraphing.php';

                        $lastDate = $DateArray[$j];
                    //if the previous date was same as current date
                    } else {
                        require 'RepeatedCode/DetailedSubjectGraphing.php';

                        $lastDate = $DateArray[$j];
                    }
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