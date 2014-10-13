<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search for subject - Admin</title>
</head>

<body>
    <?php
        //Links at the top of the page
        echo "<a href=\"adminPractitioner.php\">Practitioners</a><br>";
        echo "<a href=\"adminSubject.php\">Subjects</a><br>";

        //ensure person has logged in
        if(isset($_SESSION['username'])) {
            echo "<p>Hi, ".$_SESSION['username'].", youre in the admin pages for searching for subjects</p>";
            
            
        //if user came directly to page, without logging in, deny
        } else {
            echo "You have not logged in!";    
        }
?>
    
    
       
</body>

</html>