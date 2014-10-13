<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Add a new subject - Practitioner</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/practitionerAddNewSubject.css">
    <link rel="stylesheet" type="text/css" href="css/twoColPage.css">
</head>

<body id="bodyContainer">
    <div id="container">
    <?php
        require 'RepeatedCode/SubjectHeader.php';

        require 'RepeatedCode/PractitionerLinkBar.php';

        require 'RepeatedCode/PractitionerSubjectSidebar.php';

        echo "<div id=\"twoColContent\">";

            //ensure person has logged in
            if(isset($_SESSION['username'])) {
                echo "<p>Enter details of new subject and click add.</p>";

                echo "<form method=\"post\" id=\"addForm\" onSubmit=\"return validateForm()\" action=\"practitionerAddNewSubjectResult.php\">";
                echo "<table>";
                echo "<tr><td>First name:</td><td><input type=\"text\" id=\"pracFirstName\" onChange=\"validFirstName()\" name=\"firstName\"></td><td id=\"firstNameError\"></td></tr>";
                echo "<tr><td>Last name:</td><td><input type=\"text\" id=\"pracLastName\" onChange=\"validLastName()\" name=\"lastName\"></td><td id=\"lastNameError\"></td></tr>";
                echo "<tr><td>Birth Date (dd/mm/yyyy):</td><td><input type=\"text\" id=\"subBirthDate\" onChange=\"validBirthDate()\" name=\"birthDate\"></td><td id=\"birthDateError\"></td></tr>";
                echo "<tr><td>Sex (m or f):</td><td><input type=\"text\" id=\"subSex\" onChange=\"validSex()\" name=\"sex\"></td><td id=\"sexError\"></td></tr>";
                echo "</table>";
                echo "<br>";
                echo "<input id=\"addButton\" type=\"submit\" value=\"Add\">";
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