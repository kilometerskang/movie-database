<?php
    // queries for movie given id.
    // outputs a table of its actors, linked to actor pages.
    // Adds comment if user is coming from the Comment page.
    // shows all user comments and an "Add Comment" button that links to I1.

    $db = new mysqli('localhost', 'cs143', '', 'cs143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    // Get movie info.

    $query = "SELECT * FROM Movie WHERE id='{$_GET['id']}'";
    $rs = $db->query($query);

    if (!$rs) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }

    while ($row = $rs->fetch_assoc()){
        $title = $row['title'];
        $year = $row['year'];
        $rating = $row['rating'];
        $company = $row['company'];
    }

    // Get actors/actresses.

    $query = "SELECT id, first, last FROM Actor WHERE id IN (SELECT aid FROM MovieActor WHERE mid='{$_GET['id']}')";
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
        $actors[$i]['name'] = $row['first'].' '.$row['last'];
        $i++;
    }

    // Get comments.

    $query = "SELECT * FROM Review WHERE mid='{$_GET['id']}'";
    $rs = $db->query($query);

    if (!$rs) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }

    $i = 0;
    $comments = array();

    while($row = $rs->fetch_assoc()) {
        $comments[$i]['name'] = $row['name'];
        $comments[$i]['time'] = $row['time'];
        $comments[$i]['rating'] = $row['rating'];
        $comments[$i]['comment'] = $row['comment'];
        $i++;
    }

    // Get average score of movie.

    $query = "SELECT AVG(rating) FROM Review WHERE mid='{$_GET['id']}'";
    $rs = $db->query($query);

    if (!$rs) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }

    while ($row = $rs->fetch_assoc()) {
        $score = $row['AVG(rating)'];
    }

    if (!$score) {
        $score = "None";
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

    <title>Movie Information</title>
</head>

<body>

    <?php
        include 'nav.php';
    ?>

    <h2>
        <?php echo $title; ?>
    </h2>

    <table>
        <tr>
            <th>Year</th>
            <th>Rating</th>
            <th>Company</th>
        </tr>
        <tr>
            <td><?php echo $year ?></td>
            <td><?php echo $rating ?></td>
            <td><?php echo $company; ?></td>
        </tr>
    </table>

    <h3>
        Average Score (based on user reviews): <?php echo $score; ?>
    </h3>

    <h3>
        Cast
    </h3>

    <?php if(count($actors) == 0) : ?>
        <h4>No results found.</h4>
    <?php else : ?>
        <table>
            <tr>
                <th>Name</th>
            </tr>
            <?php foreach ($actors as $row): array_map('htmlentities', $row); ?>
            <tr>
                <td>
                    <a href="person_info.php?id=<?php echo $row['id'];?>">
                        <?php echo $row['name']; ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h3>
        User Comments
    </h3>

    <?php if(count($comments) == 0) : ?>
        <h4>None.</h4>
    <?php else : ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Time</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
            <?php foreach ($comments as $row): array_map('htmlentities', $row); ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['time'] ?></td>
                <td><?php echo $row['rating'] ?></td>
                <td><?php echo $row['comment'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <a href="comment.php?id=<?php echo $_GET['id'];?>">
        <div class="btn">
            Add Comment
        </div>
    </a>

</body>

</html>