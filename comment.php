<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">

    <title>Comment</title>
</head>

<body>

    <?php
        include 'nav.php';
    ?>

    <form action="post_comment.php?id=<?php echo $_GET['id'];?>" method="post">
        Name: <input type="text" name="name" value="Anonymous"><br>
        Time: <input type="text" name="time" value='<?php echo date('Y-m-d h:i:s');?>' readonly><br>
        Rating: <select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select><br>
        Comment: <input type="text" name="comment"><br>
        <input type="submit" class="btn">
    </form>

    <a href="movie_info.php?id=<?php echo $_GET['id'];?>">
        <div class="btn">
            Back
        </div>
    </a>

</body>

</html>