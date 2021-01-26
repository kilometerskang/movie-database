<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">

    <title>Movie Database Search</title>
</head>

<body>

    <?php
        include 'nav.php';
    ?>

    <h2>
        Search a Person or Movie Name!
    </h2>
    <form action="search_results.php" method="get">
        <input type="text" name="search"><br>
        <input type="submit">
    </form>

</body>

</html>