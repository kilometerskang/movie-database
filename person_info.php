<?php
    // queries for actor given id.
    // outputs a table of their movies, linked to movie pages.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    // Get actor info.

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

    // Get movies.

    $query = "SELECT id, title FROM Movie WHERE id IN (SELECT mid FROM MovieActor WHERE aid='{$_GET['id']}')";
    $rs = $db->query($query);

    if (!$rs) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }

    $i = 0;
    $movies = array();

    while($row = $rs->fetch_assoc()) {
        $movies[$i]['id'] = $row['id'];
        $movies[$i]['title'] = $row['title'];
        $i++;
    }

    $rs->free();
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">

    <title>Person Information</title>
</head>

<body>

    <?php
        include 'nav.php';
    ?>

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
            <td><?php echo $dod ? $dod : 'N/A'; ?></td>
        </tr>
    </table>

    <h3>
        Movies that <?php echo $first.' '.$last; ?> was in!
    </h3>

    <?php if(count($movies) == 0) : ?>
        <h4>None.</h4>
    <?php else : ?>
        <table>
            <tr>
                <th>Title</th>
            </tr>
            <?php foreach ($movies as $row): array_map('htmlentities', $row); ?>
            <tr>
                <td>
                    <a href="movie_info.php?id=<?php echo $row['id'];?>">
                        <?php echo $row['title']; ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>

</html>