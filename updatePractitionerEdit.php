<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="validation.js"></script>
    <title>Edit practitioner - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/updatePractitionerEdit.css">
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
                    //determine which practitioner was selected to be updated
                    $selectedPractitionerID = $_POST['practitionerRadio'];
                    $_SESSION['updatePractitionerID'] = $selectedPractitionerID;

                    echo "<p>Make changes to practitioner details and click update.</p>";

                    //obtain selected practitioner details
                    $practitionerDetailsQuery = "SELECT Practitioner.FirstName, Practitioner.LastName, Login.Username, Login.Password FROM Practitioner INNER JOIN Login ON Practitioner.Username = Login.Username WHERE Practitioner.PractitionerID=$selectedPractitionerID;";
                    $practitionerDetailsResult = odbc_exec($conn, $practitionerDetailsQuery);
                    while(odbc_fetch_row($practitionerDetailsResult)) {
                        $practitionerFirstName = odbc_result($practitionerDetailsResult, "FirstName");
                        $practitionerLastName = odbc_result($practitionerDetailsResult, "LastName");
                        $practitionerUsername = odbc_result($practitionerDetailsResult, "Username");
                        $practitionerPassword = odbc_result($practitionerDetailsResult, "Password");
                    }
                    $_SESSION['oldPractitionerUsername'] = $practitionerUsername;
                    /*
                    //obtain list of usernames for validation
                    $usernameListQuery = "SELECT Login.Username FROM Login;";
                    $usernameListResult = odbc_exec($conn, $usernameListQuery);
                    $count = 0;
                    while(odbc_fetch_row($usernameListResult)) {
                        $usernameList[$count] = odbc_result($usernameListResult, "Username");
                        $count += 1;
                    } */
                    //for($i = 0; $i < sizeof($usernameList); $i++) {
                    //    echo $usernameList[$i]."<br>";    
                    //}

                    //put usernames into one string delimited by commas so javaScript can parse it in client side validation
                    //$usernameList = implode(",", $usernameList);


                    echo "<form method=\"post\" id=\"updateForm\" onSubmit=\"return validateForm()\" action=\"editPractitionerResult.php\">";
                    echo "<table>";
                    echo "<tr><td>First name:</td><td><input type=\"text\" id=\"pracFirstName\" value=".$practitionerFirstName." onChange=\"validFirstName()\" name=\"firstName\"></td><td id=\"firstNameError\">OK!</td></tr>";
                    echo "<tr><td>Last name:</td><td><input type=\"text\" id=\"pracLastName\" value=".$practitionerLastName." onChange=\"validLastName()\" name=\"lastName\"></td><td id=\"lastNameError\">OK!</td></tr>";
                    echo "<tr><td>Username:</td><td><input type=\"text\" id=\"pracUsername\" value=".$practitionerUsername." onChange=\"validUsername()\" name=\"username\"></td><td id=\"usernameError\">OK!</td></tr>";
                    echo "<tr><td>Password:</td><td><input type=\"text\" id=\"pracPassword\" value=".$practitionerPassword." onChange=\"validPassword()\" name=\"password\"></td><td id=\"passwordError\">OK!</td></tr>";
                    echo "</table>";

                    echo "<br>";
                    echo "<input id=\"updateButton\" type=\"submit\" value=\"Update\">";
                    echo "<br>";
                    echo "</form>";
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