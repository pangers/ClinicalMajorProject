<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Add new test trial - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/addTestTrial.css">
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

                    echo "<p>Select a subject to add a test trial for.</p>";

                    //obtain current subject details
                    $currentSubjectQuery = "SELECT * FROM Subject;";
                    $currentSubjectssResult = odbc_exec($conn, $currentSubjectQuery);

                    echo "<form method=\"post\" action=\"addTestTrialForm.php\">";
                    //build subject table dynamically
                    echo "<table><th>Subject ID</th><th>Name</th><th>Birth Date</th><th>Sex</th><th>Selection</th>";
                    //while there are still records to list, make a new table row with subject details
                    while(odbc_fetch_row($currentSubjectssResult)) {
                        $subjectID = odbc_result($currentSubjectssResult, "SubjectID");
                        $subjectFirstName = odbc_result($currentSubjectssResult, "FirstName");
                        $subjectLastName = odbc_result($currentSubjectssResult, "LastName");
                        $birthDate = odbc_result($currentSubjectssResult, "BirthDate");
                        $sex = odbc_result($currentSubjectssResult, "Sex");
                        echo "<tr><td>".$subjectID."</td><td>".$subjectFirstName." ".$subjectLastName ."</td><td>".$birthDate."</td><td>".$sex."</td><td><input type=\"radio\" name=\"subjectRadio\" value=".$subjectID." checked=\"checked\"></td></tr>".PHP_EOL;
                    }
                    echo "</table>";
                    echo "<br>";
                    echo "<input type=\"submit\" id=\"selectButton\" name=\"submit\" value=\"Select\">";
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