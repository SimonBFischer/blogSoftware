<?php
    include 'database/dbh.php';
    include 'header.php';

    //add comment
    if (isset($_POST['comment-add-title'])) {
        //check inputs
        $commentInputError = "";
        $inputError = false;

        if ($_POST['comment-add-title'] == "") {
            $commentInputError = $commentInputError."Your comment needs a title. ";
            $inputError = true;
        }

        if ($_POST['comment-add-text'] == "") {
            $commentInputError = $commentInputError."Your comment needs a text. ";
            $inputError = true;
        }

        //add the comment
        if ($inputError == false) {
            mysqli_query($conn, "INSERT INTO comments (postId, title, text, date) VALUES ('".$_SESSION['currentPost']['id']."', '".$_POST['comment-add-title']."','".$_POST['comment-add-text']."','2022-02-17 22:37:00');");
        }
    }

    //back button
    if (isset($_POST['goBackToIndex'])) {
        unset($_SESSION['currentPost']);
        header ('Location: index.php');
    }
?>

<body>
    <!-- back button -->
    <form class='back-to-index-form' method='POST'>
        <input type='hidden' name='goBackToIndex' value='true'>
        <button class='back-to-index-btn' type='submit'>Back</button>
    </form>

    <!-- post -->
    <div class="post-full">
        <div class="post-full-title">
            <?php
                echo $_SESSION['currentPost']['title'];
            ?>
        </div>
        <div class="post-full-text">
            <?php
                echo $_SESSION['currentPost']['text'];
            ?>
        </div>
    </div>

    <!-- comments -->
    <div class="post-comments-heading">Comments</div>

    <!-- add comment -->
    <div class="post-comment-add-div">
        <div class="post-comment-description">Add a comment:</div>

        <form class="comment-add-form" method="post">
            <input type="text" class="comment-add-title" name="comment-add-title" placeholder="Title">
            <input type="text" class="comment-add-text" name="comment-add-text" placeholder="Text">
            <?php
            if (isset($commentInputError)) {
                echo "<div class = comment-input-error-div><p class='input-error'>".$commentInputError."</p></div>";
            }
            ?><br>
            <button type="submit" class="comment-add-btn">Comment</button>
        </form>
    </div>

    <?php
    //display all comments of the current post
    $rowsOfCommentsOfCurrentPost = mysqli_query($conn, "SELECT * FROM comments WHERE postId='".$_SESSION['currentPost']['id']."';");
    
    //if there are comments, display them
    $numberOfComments = mysqli_num_rows($rowsOfCommentsOfCurrentPost);

    if ($numberOfComments > 0) {
        foreach ($rowsOfCommentsOfCurrentPost as $oneRow) {
            echo "
                <div class='comment'>
                    <div class='comment-title'>".$oneRow['title']."</div>
                    <div class='comment-text'>".$oneRow['text']."</div>
                </div>
            ";
        }
    } else {
        echo "There are no comments regarding this post.";
    }
    ?>
    

</body>
</html>