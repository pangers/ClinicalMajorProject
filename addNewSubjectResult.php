<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Insert subject result - Admin</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/addNewSubjectResult.css">
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

                    //obtain existing subject ID's
                    $currentSubjectsIDQuery = "SELECT SubjectID FROM Subject;";
                    $currentSubjectsIDResult = odbc_exec($conn, $currentSubjectsIDQuery);

                    //store resulting query into php array
                    $count = 0;
                    while(odbc_fetch_row($currentSubjectsIDResult)) {
                        $existingSubjectID[$count] = odbc_result($currentSubjectsIDResult, "SubjectID");
                        $count += 1;
                    }

                    //find an unused 4 digit subject ID
                    $subjectID = 0;  
                    for ($i = 1000; $i < 10000; $i++) {
                        if(!in_array($i, $existingSubjectID)) {
                            $subjectID = $i;        
                            break;
                        }
                    }

                    //create query to insert subject table
                    $insertQuery = "INSERT INTO Subject (SubjectID, FirstName, LastName, BirthDate, Sex) VALUES ('$subjectID', '$firstName', '$lastName', '$birthDate', '$sex');";
                    $insertQueryResult = odbc_exec($conn, $insertQuery);
                    echo "<h3>Add successful</h3>";
                    echo "<p>Subject added to database.</p>";

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