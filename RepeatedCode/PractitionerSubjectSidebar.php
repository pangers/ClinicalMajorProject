<?php
    echo "<div id=\"sidebar\">";
        echo "<h3>Practitioner actions</h3>";
        echo "<form method=\"link\" action=\"practitionerSearchSubject.php\"><input type=\"submit\" value=\"Search subject\"></form>";
        echo "<form method=\"link\" action=\"practitionerAddTestTrial.php\"><input type=\"submit\" value=\"Add test trial\"></form>";
        echo "<form method=\"link\" action=\"practitionerAddNewSubject.php\"><input type=\"submit\" value=\"Add new subject\"></form>";
        echo "<form method=\"link\" action=\"practitionerupdateSubject.php\"><input type=\"submit\" value=\"Update subject\"></form>";
        echo "<form method=\"link\" action=\"practitionerEditTestTrial.php\"><input type=\"submit\" value=\"Edit test trial\"></form>";
        echo "<br>";
    echo "</div>";
?>