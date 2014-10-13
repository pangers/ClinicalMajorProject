<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Add new practitioners - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/addNewPractitioner.css">
    <link rel="stylesheet" type="text/css" href="css/twoColPage.css">
</head>

<body id="bodyContainer">
    <div id="container">
        <?php
            require 'RepeatedCode/PractitionerHeader.php';

            require 'RepeatedCode/AdminLinkBar.php';

            require 'RepeatedCode/AdminPractitionerSidebar.php';

            require 'RepeatedCode/DatabaseConnection.php';

            echo "<div id=\"twoColContent\">";
                //ensure person has logged in
                if(isset($_SESSION['username'])) {
                    echo "<p>Enter details of new practitioner and click add.</p>";

                    echo "<form method=\"post\" id=\"addForm\" onSubmit=\"return validateForm()\" action=\"addNewPractitionerResult.php\">";
                    echo "<table>";
                    echo "<tr><td>First name:</td><td><input type=\"text\" id=\"pracFirstName\" onChange=\"validFirstName()\" name=\"firstName\"></td><td id=\"firstNameError\"></td></tr>";
                    echo "<tr><td>Last name:</td><td><input type=\"text\" id=\"pracLastName\" onChange=\"validLastName()\" name=\"lastName\"></td><td id=\"lastNameError\"></td></tr>";
                    echo "<tr><td>Username:</td><td><input type=\"text\" id=\"pracUsername\" onChange=\"validUsername()\" name=\"username\"></td><td id=\"usernameError\"></td></tr>";
                    echo "<tr><td>Password:</td><td><input type=\"text\" id=\"pracPassword\" onChange=\"validPassword()\" name=\"password\"></td><td id=\"passwordError\"></td></tr>";
                    echo "</table>";
                    echo "<br>";
                    echo "<input id=\"insertNow\" id=\"addButton\" type=\"submit\" value=\"Add\">";
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