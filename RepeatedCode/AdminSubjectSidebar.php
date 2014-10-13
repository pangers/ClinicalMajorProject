<?php
    echo "<div id=\"sidebar\">";
        echo "<h3>Administrative actions</h3>";
        echo "<form method=\"link\" action=\"administratorSearchSubject.php\"><input type=\"submit\" value=\"Search subject\"></form>";
        echo "<form method=\"link\" action=\"updateSubject.php\"><input type=\"submit\" value=\"Update subject\"></form>";
        echo "<form method=\"link\" action=\"addNewSubject.php\"><input type=\"submit\" value=\"Add new subject\"></form>";
        echo "<form method=\"link\" action=\"assignPracToSubject.php\"><input type=\"submit\" value=\"Assign practitioners to subject\"></form>";
        echo "<form method=\"link\" action=\"addTestTrial.php\"><input type=\"submit\" value=\"Add test trial\"></form>";
        echo "<form method=\"link\" action=\"editTestTrial.php\"><input type=\"submit\" value=\"Edit test trial\"></form>";
        echo "<form method=\"link\" action=\"dataTrendGraph.php\"><input type=\"submit\" value=\"Data trend graph\"></form>";
        echo "<br>";
    echo "</div>";
?>