<?php
    // queries for actor given id.
    // outputs a table of their movies, linked to movie pages.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $query = "SELECT * FROM Actor WHERE id='{$_GET['id']}'";
    $rs = $db->query($query);

    if (!$rs) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }

    while ($row = $rs->fetch_assoc()){
        $first = $row['first'];
        $last = $row['last'];
        $sex = $row['sex'];
        $dob = $row['dob'];
        $dod = $row['dod'];
    }

    $rs->free();
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Actor Information</title>
</head>

<body>

    <h2>
        <?php echo $first." ".$last; ?>
    </h2>

    <table>
        <tr>
            <th>Sex</th>
            <th>Date of Birth</th>
            <th>Date of Death</th>
        </tr>
        <tr>
            <td><?php echo $sex ?></td>
            <td><?php echo $dob ?></td>
            <td><?php echo $dod ? $dod : "Still Alive"; ?></td>
        </tr>
    </table>

    <h2>
        Movies that <?php echo $first." ".$last; ?> was in!
    </h2>

    

</body>

</html>