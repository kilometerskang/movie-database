<?php
    // posts comment and redirects to movie page.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $id = $_GET['id'];

    if (isset($_POST['name'])) {
        $query = "INSERT INTO Review VALUES ('{$_POST['name']}', '{$_POST['time']}', '{$_GET['id']}', '{$_POST['rating']}', '{$_POST['comment']}')";
        $db->query($query);

        header("Location: movie_info.php?id=$id");
    }

    $db->close();
?>