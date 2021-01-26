<?php
    // queries for actor names and movies with the given search terms.
    // outputs a table of actors and/or a table of movies.
    // each item is linked to an actor page or movie page.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $search = preg_split('/\s+/', $_GET["search"]);
    $num_words = count($search);

    $actors = array();
    $movies = array();

    if ($num_words == 2) {
        // try (first, last) and (last, first) for actor names.
        
        $query = "SELECT * FROM Actor WHERE first='{$search[0]}' AND last='{$search[1]}'";
        $rs = $db->query($query);

        if (!$rs) {
            $errmsg = $db->error;
            print "Query failed: $errmsg <br>";
            exit(1);
        }

        $i = 0;

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
    } elseif ($num_words == 1) {
        // try first and last for actor names.
        
        $query = "SELECT DISTINCT * FROM Actor WHERE first='{$search[0]}' OR last='{$search[0]}'";
        $rs = $db->query($query);

        if (!$rs) {
            $errmsg = $db->error;
            print "Query failed: $errmsg <br>";
            exit(1);
        }

        $i = 0;

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

    // search for movies.

    $query = "SELECT * FROM Movie WHERE ";
    for($i = 0; $i < count($search); $i++) {
        $query .= "title LIKE '%".$search[$i]."%'";
        if ($i != count($search) - 1) {
            $query .= " AND ";
        }
    }

    $rs = $db->query($query);

    if (!$rs) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }

    $i = 0;

    while($row = $rs->fetch_assoc()) {
        $movies[$i]['id'] = $row['id'];
        $movies[$i]['title'] = $row['title'];
        $movies[$i]['year'] = $row['year'];
        $movies[$i]['rating'] = $row['rating'];
        $movies[$i]['company'] = $row['company'];
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

    <title>Search Results</title>
</head>

<body>

    <?php
        include 'nav.php';
    ?>

    <h2>
        Search Results for '<?php echo $_GET["search"]; ?>'
    </h2>

    <h3>
        Actors
    </h3>

    <?php if(count($actors) == 0) : ?>
        <h4>No results found.</h4>
    <?php else : ?>
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
                    <a href="person_info.php?id=<?php echo $row['id'];?>">
                        <?php echo $row['first'].' '.$row['last']; ?>
                    </a>
                </td>
                <td><?php echo $row['sex']; ?></td>
                <td><?php echo $row['dob']; ?></td>
                <td><?php echo $row['dod'] ? $row['dod'] : 'N/A'; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h3>
        Movies
    </h3>

    <?php if(count($movies) == 0) : ?>
        <h4>No results found.</h4>
    <?php else : ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Rating</th>
                <th>Company</th>
            </tr>
            <?php foreach ($movies as $row): array_map('htmlentities', $row); ?>
                <tr>
                    <td>
                        <a href="movie_info.php?id=<?php echo $row['id'];?>">
                            <?php echo $row['title']; ?>
                        </a>
                    </td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['rating']; ?></td>
                    <td><?php echo $row['company']; ?></td>
                </tr>
                <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>

</html>