<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Update subject result - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/editSubjectResult.css">
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
                    $firstName = $_POST["firstName"];   
                    $lastName = $_POST["lastName"];
                    $birthDate = $_POST["birthDate"];
                    $sex = $_POST["sex"];
                    $subjectID = $_SESSION['updateSubjectID'];

                    //create query to update subject table
                    $updateQuery = "UPDATE Subject SET FirstName='$firstName', LastName='$lastName', BirthDate='$birthDate', Sex='$sex' WHERE SubjectID=$subjectID;";
                    $updateSubjectResult = odbc_exec($conn, $updateQuery);

                    echo "<h3>Update successful</h3>";
                    echo "<p>Practitioner details updated.</p>";

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