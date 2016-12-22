<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SWNW - TEST</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="well">
                        <form method="POST" action="#">
                            <input type="text" name="title" placeholder="Titel">
                            <input type="text" name="author" placeholder="Autor">
                            <input type="text" name="rating" placeholder="Bewertung">
                            <input type="submit" name="send" value="Eintragen!">
                            </div>
                        </form>
                        <div class="well">
                            <form method="POST" action="#">
                                <input type="text" name="id" placeholder="ID welche gelöscht werden soll.">
                                <input type="submit" name="delete" value="Löschen!">
                            </form>    
                        </div>
                    </div>
                <div class="col-md-4">
                    
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $dbname = "swnw_test_db";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if (isset($_POST['send'])) {                      
                        // prepare and bind
                        $stmt = $conn->prepare("INSERT INTO books (id, title, author, rating) VALUES (NULL , ?, ?, ?)");
                        $stmt->bind_param("sss", $val1, $val2, $val3);

                        // set parameters and execute
                        $val1 = $_POST['title'];
                        $val2 = $_POST['author'];
                        $val3 = $_POST['rating'];
                        $stmt->execute();
                    }

                    if (isset($_POST['delete'])) {
                        $id = $_POST['id'];
                        $sql = "DELETE FROM books WHERE id=$id ";

                        if ($conn->query($sql) === TRUE) {
                            echo "<div class='alert alert-info'><strong>Info!</strong> Ein buch wurde gelöscht!</div>";
                        } else {
                            echo "Error deleting record: " . $conn->error;
                            echo $sql;
                        }
                    }
                    
                    //formatting
                    echo "</div>"; //close line 33  col-md-4 
                    echo "<div class='col-md-4'><table class='table table-striped'><thead><tr><th>ID</th><th>Titel</th><th>Autor</th><th>Ratin 0/10</th></tr></thead><tbody>";
                    
                    $sql = "SELECT * FROM books";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><th>" . $row['id'] . "</th><th>" . $row['title'] . "</th><th>" . $row['author'] . "</th><th>" . $row['rating'] . "</th></tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    //formatting
                    echo "</tbody></table></div>"; //close line 75 col-md-4
                    ?>
                </div>
            </div>
    </body>
</html>
