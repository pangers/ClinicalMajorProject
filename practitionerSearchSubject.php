<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search subjects - Practitioner</title>
    
    <script src="searchValidation.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/practitionerSearchSubject.css">
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
                    
                    echo "<p>Search for a subject using a criteria in the drop-down list and click search.</p>".PHP_EOL;

                    echo "<form method=\"post\" id=\"searchForm\" onSubmit=\"return validateSearchForm()\" action=\"practitionerSearchSubjectResult.php\">";
                    echo "<table>";
                    
                    echo "<tr><td>Search phrase:</td><td><input type=\"text\" id=\"searchPhrase\" onChange=\"validSearchPhrase()\" name=\"searchPhrase\"></td><td id=\"searchPhraseError\"></td></tr>";
                    echo "<tr><td>Search criteria:</td><td>";
                    echo "<select id=\"searchCriteria\" name=\"searchCriteria\">";
                        echo "<option value=\"firstName\">First Name</option>";
                        echo "<option value=\"lastName\">Last Name</option>";
                        echo "<option value=\"birthDate\">Birth Date</option>";
                        echo "<option value=\"sex\">Sex</option>";
                    echo "</select>";
                    echo "</td></tr>";
                    echo "</table>";
                    
                    echo "<br>";
                    echo "<br>";
                    echo "<input id=\"searchButton\" type=\"submit\" value=\"Search\">";
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