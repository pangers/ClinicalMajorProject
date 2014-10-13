<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Edit subject - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/updateSubjectEdit.css">
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
                    $_SESSION['updateSubjectID'] = $selectedSubjectID;
                    echo "<p>Make changes to subject details and click update.</p>";

                    //obtain selected subject details
                    $subjectDetailsQuery = "SELECT * FROM Subject WHERE SubjectID=$selectedSubjectID;";
                    $subjectDetailsResult = odbc_exec($conn, $subjectDetailsQuery);
                    while(odbc_fetch_row($subjectDetailsResult)) {
                        $subjectFirstName = odbc_result($subjectDetailsResult, "FirstName");
                        $subjectLastName = odbc_result($subjectDetailsResult, "LastName");
                        $subjectBirthDate = odbc_result($subjectDetailsResult, "BirthDate");
                        $subjectSex = odbc_result($subjectDetailsResult, "Sex");
                    }

                    echo "<form method=\"post\" id=\"updateForm\" onSubmit=\"return validateForm()\" action=\"editSubjectResult.php\">";
                    echo "<table>";
                    echo "<tr><td>First name:</td><td><input type=\"text\" id=\"pracFirstName\" value=".$subjectFirstName." onChange=\"validFirstName()\" name=\"firstName\"></td><td id=\"firstNameError\">OK!</td></tr>";
                    echo "<tr><td>Last name:</td><td><input type=\"text\" id=\"pracLastName\" value=".$subjectLastName." onChange=\"validLastName()\" name=\"lastName\"></td><td id=\"lastNameError\">OK!</td></tr>";
                    echo "<tr><td>Birth Date (dd/mm/yyyy):</td><td><input type=\"text\" id=\"subBirthDate\" value=".$subjectBirthDate." onChange=\"validBirthDate()\" name=\"birthDate\"></td><td id=\"birthDateError\">OK!</td></tr>";
                    echo "<tr><td>Sex (m or f):</td><td><input type=\"text\" id=\"subSex\" value=".$subjectSex." onChange=\"validSex()\" name=\"sex\"></td><td id=\"sexError\">OK!</td></tr>";
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