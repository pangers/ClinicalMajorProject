<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search subjects - Administrator</title>

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/administratorSearchSubjectResult.css">
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
                    
                    //echo "<p>This is the search subject result page, drop down was ".$_POST['searchCriteria']."</p>".PHP_EOL;
                    $criteriaSelection = $_POST['searchCriteria'];
                    $searchPhrase = $_POST['searchPhrase'];
                    
                    //a number of queries depending on search criteria used
                    //obtain current practitioner details
                    if($criteriaSelection == 'firstName') {
                        $searchQuery = "SELECT * FROM Subject WHERE FirstName='$searchPhrase';";
                        $searchResult = odbc_exec($conn, $searchQuery);
                    } else if ($criteriaSelection == 'lastName') {
                        $searchQuery = "SELECT * FROM Subject WHERE LastName='$searchPhrase';";
                        $searchResult = odbc_exec($conn, $searchQuery);
                    } else if ($criteriaSelection == 'birthDate') {
                        $searchQuery = "SELECT * FROM Subject WHERE BirthDate='$searchPhrase';";
                        $searchResult = odbc_exec($conn, $searchQuery);
                    } else if ($criteriaSelection == 'sex') {
                        $searchQuery = "SELECT * FROM Subject WHERE Sex='$searchPhrase';";
                        $searchResult = odbc_exec($conn, $searchQuery);
                    }
                   
                    //retrieve returned records
                    $count = 0;
                    while(odbc_fetch_row($searchResult)) {
                        $subjectID[$count] = odbc_result($searchResult, "SubjectID");
                        $subjectFirstName[$count] = odbc_result($searchResult, "FirstName");
                        $subjectLastName[$count] = odbc_result($searchResult, "LastName");
                        $subjectBirthDate[$count] = odbc_result($searchResult, "BirthDate");
                        $subjectSex[$count] = odbc_result($searchResult, "Sex");
                       $count += 1;
                    }
                    
                    if ($count == 0) {
                        echo "<p>There were no search results found.</p>";
                        echo "<br>";
                    } else {
                        //build practitioner table dynamically
                        echo "<p>The search results are shown below.</p>";
                        echo "<table><th>Subject ID</th><th>Name</th><th>Birth Date</th><th>Sex</th>";
                        for($i = 0; $i < sizeof($subjectID); $i++) {      
                            echo "<tr><td>".$subjectID[$i]."</td><td>".$subjectFirstName[$i]." ".$subjectLastName[$i]."</td><td>".$subjectBirthDate[$i]."</td><td>".$subjectSex[$i]."</td></tr>".PHP_EOL;    
                        }
                        echo "</table>";
                        echo "<br>";
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