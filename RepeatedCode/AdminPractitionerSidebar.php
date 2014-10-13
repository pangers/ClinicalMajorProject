<?php
    echo "<div id=\"sidebar\">";
        echo "<h3>Administrative actions</h3>";
        echo "<form method=\"link\" action=\"updatePractitioner.php\"><input type=\"submit\" value=\"Update practitioner\"></form>";
        echo "<form method=\"link\" action=\"addNewPractitioner.php\"><input type=\"submit\" value=\"Add new practitioner\"></form>";
        echo "<form method=\"link\" action=\"assignSubToPractitioner.php\"><input type=\"submit\" value=\"Assign subjects to practitioner\"></form>";
        echo "<br>";
    echo "</div>";
?>