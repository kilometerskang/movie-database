<?php
    // queries for actor names and movies with the given search terms.
    // outputs a table of actors and/or a table of movies.
    // each item is linked to an actor page or movie page.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $fail_message = "No results found. <br>";

    $search = explode(" ", $_GET["search"]);
    $num_words = count($search);

    if ($num_words > 0) {
        if ($num_words > 2) {
            $actors = array();
        } elseif ($num_words == 2) {
            // try (first, last) and (last, first) for actor names.
            
            $query = "SELECT * FROM Actor WHERE first='{$search[0]}' AND last='{$search[1]}'";
            $rs = $db->query($query);

            if (!$rs) {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br>";
                exit(1);
            }

            $i = 0;
            $actors = array();

            while($row = $rs->fetch_assoc()) {
                $actors[$i]['id'] = $row['id'];
                $actors[$i]['first'] = $row['first'];
                $actors[$i]['last'] = $row['last'];
                $actors[$i]['sex'] = $row['sex'];
                $actors[$i]['dob'] = $row['dob'];
                $actors[$i]['dod'] = $row['dod'];
                $i++;
            }

            $query = "SELECT * FROM Actor WHERE first='{$search[1]}' AND last='{$search[0]}'";
            $rs = $db->query($query);

            if (!$rs) {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br>";
                exit(1);
            }

            while($row = $rs->fetch_assoc()) {
                $actors[$i]['id'] = $row['id'];
                $actors[$i]['first'] = $row['first'];
                $actors[$i]['last'] = $row['last'];
                $actors[$i]['sex'] = $row['sex'];
                $actors[$i]['dob'] = $row['dob'];
                $actors[$i]['dod'] = $row['dod'];
                $i++;
            }
        } else {
            // try first and last for actor names.
            
            $query = "SELECT DISTINCT * FROM Actor WHERE first='{$search[0]}' OR last='{$search[0]}'";
            $rs = $db->query($query);

            if (!$rs) {
                $errmsg = $db->error;
                print "Query failed: $errmsg <br>";
                exit(1);
            }

            $i = 0;
            $actors = array();

            while($row = $rs->fetch_assoc()) {
                $actors[$i]['id'] = $row['id'];
                $actors[$i]['first'] = $row['first'];
                $actors[$i]['last'] = $row['last'];
                $actors[$i]['sex'] = $row['sex'];
                $actors[$i]['dob'] = $row['dob'];
                $actors[$i]['dod'] = $row['dod'];
                $i++;
            }
        }

        // search for movie.


    } else {
        print $fail_message;
    }

    $rs->free();
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Search Results</title>
</head>

<body>

    <h2>
        Search Results for '<?php echo $_GET["search"]; ?>'
    </h2>

    <h4>
        Actors
    </h4>

    <table>
        <tr>
            <th>Name</th>
            <th>Sex</th>
            <th>Date of Birth</th>
            <th>Date of Death</th>
        </tr>
        <?php foreach ($actors as $row): array_map('htmlentities', $row); ?>
        <tr>
            <td>
                <a href="b1.php?id=<?php echo $row['id'];?>">
                    <?php echo $row['first']." ".$row['last']; ?>
                </a>
            </td>
            <td><?php echo $row['sex']; ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $row['dod'] ? $row['dod'] : "Still Alive"; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h4>
        Movies
    </h4>

    <table>
        <tr>
            <th>Title</th>
            <th>Year</th>
            <th>Rating</th>
            <th>Company</th>
        </tr>
        <?php foreach ($actors as $row): array_map('htmlentities', $row); ?>
        <tr>
            <td><?php echo $row['first']." ".$row['last']; ?></td>
            <td><?php echo $row['sex']; ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $row['dod'] ? $row['dod'] : "Still Alive"; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>