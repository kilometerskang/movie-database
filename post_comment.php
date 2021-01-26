<?php
    // posts comment and redirects to movie page.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $id = $_GET['id'];

    $datetime = date('Y-m-d h:i:s');

    if (isset($_POST['name'])) {
        $query = "INSERT INTO Review VALUES ('{$_POST['name']}', '{$datetime}', '{$_GET['id']}', '{$_POST['rating']}', '{$_POST['comment']}')";
        $db->query($query);

        header("Location: movie_info.php?id=$id");
    }

    $db->close();
?>