<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Update Subjects - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/updateSubject.css">
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

                    echo "<p>Select which subject to update and click edit.</p>";

                    //obtain current subject details
                    $currentSubjectsQuery = "SELECT * FROM Subject;";
                    $currentSubjectsResult = odbc_exec($conn, $currentSubjectsQuery);

                    echo "<form method=\"post\" action=\"updateSubjectEdit.php\">";
                    //build practitioner table dynamically
                    echo "<table><th>Subject ID</th><th>Name</th><th>BirthDate</th><th>Sex</th><th>Selection</th>";
                    //while there are still records to list, make a new table row with practitioner name and username
                    while(odbc_fetch_row($currentSubjectsResult)) {
                        $subjectID = odbc_result($currentSubjectsResult, "SubjectID");
                        $subjectFirstName = odbc_result($currentSubjectsResult, "FirstName");
                        $subjectLastName = odbc_result($currentSubjectsResult, "LastName");
                        $subjectBirthDate = odbc_result($currentSubjectsResult, "BirthDate");
                        $subjectSex = odbc_result($currentSubjectsResult, "Sex");
                        echo "<tr><td>".$subjectID."</td><td>".$subjectFirstName." ".$subjectLastName ."</td><td>".$subjectBirthDate."</td><td>".$subjectSex."</td><td><input type=\"radio\" name=\"subjectRadio\" value=".$subjectID." checked=\"checked\"></td></tr>".PHP_EOL;
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