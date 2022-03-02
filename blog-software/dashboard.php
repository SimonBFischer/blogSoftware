<?php
    include 'database/dbh.php';
    include 'header.php';

    //back button
    if (isset($_POST['goBackToIndex'])) {
        header ('Location: index.php');
        unset($_SESSION['currentPost-dashboard']);
    }

    //check if button add Post in the add Post interface was clicked; if so, add the post in the database
    if (isset($_POST['post-addPost-title-input'])) {
        mysqli_query($conn, "INSERT INTO posts (title, text, date) VALUES ('".$_POST['post-addPost-title-input']."', '".$_POST['post-addPost-text-textarea']."', '2022-02-17 22:37:00');");
    }

    //check if button See more of a Post was clicked; if so, set up session $currentPostDashboard
    if (isset($_POST['postIdInput'])) {
        $_SESSION['currentPost-dashboard'] = array('id' => '', 'title' => '', 'text' => '', 'date' => '');

        //get row of posts which has the current Id
        $currentRowOfPosts = mysqli_query($conn, "SELECT * FROM posts WHERE id='".$_POST['postIdInput']."';");
        $currentRowOfPostsFetched = mysqli_fetch_assoc($currentRowOfPosts);

        //assign all values to array $currentPostDashboard
        $_SESSION['currentPost-dashboard']['id'] = $currentRowOfPostsFetched['id'];
        $_SESSION['currentPost-dashboard']['title'] = $currentRowOfPostsFetched['title'];
        $_SESSION['currentPost-dashboard']['text'] = $currentRowOfPostsFetched['text'];
        $_SESSION['currentPost-dashboard']['date'] = $currentRowOfPostsFetched['date'];
    }

    //check if button Safe changes in an opened Post was clicked; if so, safe the changes of the post in the database
    if (isset($_POST['post-title-input'])) {
        mysqli_query($conn,
        "UPDATE posts
        SET title='".$_POST['post-title-input']."', text='".$_POST['post-text-textarea']."'
        WHERE id='".$_SESSION['currentPost-dashboard']['id']."';"
        );

        //update the session currentPost-dashboard (for having the values updated in the currenPots column right after clicking the safe changes button)
        $_SESSION['currentPost-dashboard']['title'] = $_POST['post-title-input'];
        $_SESSION['currentPost-dashboard']['text'] = $_POST['post-text-textarea'];
    }

    //check if button Cancel in addPost was clicked; if so, unset the current session in order to quit the add Post interface
    if (isset($_POST['cancelAddPostBtn'])) {
        unset($_SESSION['currentPost-dashboard']);
    }

    //check if button Cancel in an opened Post was clicked; if so, destroy session currentPost-dashboard and don't safe changes
    if (isset($_POST['cancelChangesBtn'])) {
        unset($_SESSION['currentPost-dashboard']);
    }

    //check if button Delete of a comment of an opened post was clicked; if so, delete the comment
    if (isset($_POST['deleteCommentOfAPostInput'])) {
        mysqli_query($conn, "DELETE FROM comments WHERE id='".$_POST['deleteCommentOfAPostInput']."';");
    }

    //check if button Delete of an opened post was clicked; if so, delete the post and unset the session currentPost-dashboard
    if (isset($_POST['deletePostInput'])) {
        mysqli_query($conn, "DELETE FROM posts WHERE id='".$_POST['deletePostInput']."';");
        unset($_SESSION['currentPost-dashboard']);
    }

?>

<body>
<!-- back button -->
<form class='back-to-index-form-dashboard' method='POST'>
    <input type='hidden' name='goBackToIndex' value='true'>
    <button class='back-to-index-btn-dashboard' type='submit'>Back</button>
</form>

<div class="dashboard-div">
    <div class="dashboard-div-posts-column">

        <div class="dashboard-div-posts-column-addPost">
            <?php
                echo "
                <div class='dashboard-div-post-column-addPost-div'>
                    <form method='POST'>
                        <input type='hidden' name='addPostInput' value='addPost'>
                        <button class='dashboard-addPost-btn'>Add post</button>
                    </form>
                </div>
                ";
            ?>
        </div>

        <div class="dashboard-div-posts-column-displayPosts">
            <?php
            //display posts
            //get all row(s) of posts and check how many of them there are
            $rowsOfPosts = mysqli_query($conn, "SELECT * FROM posts;");

            $numberOfRowsOfPosts = mysqli_num_rows($rowsOfPosts);

            $estimatedId = 1;
            //loop through every post and display it
            for ($postNumber = 1; $postNumber <= $numberOfRowsOfPosts; $postNumber++) {

                //get the id of the next row (there can be spaces between ids after e.g. deleting a post)
                $nextIdFound = false;
            

                while ($nextIdFound == false){
                    $rowWithId = mysqli_query($conn, "SELECT * FROM posts WHERE id='".$estimatedId."'");
                    $numberOfRowWithId = mysqli_num_rows($rowWithId);

                    if ($numberOfRowWithId == 1) {
                        $nextIdFound = true;
                        $postId = $estimatedId;
                    }
                    $estimatedId++;
                }

                //display post with id
                $rowWithIdFetched = mysqli_fetch_assoc($rowWithId);

                $postTitle = $rowWithIdFetched['title'];
                $postText = $rowWithIdFetched['text'];
                $postDate = $rowWithIdFetched['date'];

                echo "
                <div class='dashboard-post-overview-div'>
                    <div class='dashboard-post-overview-title'>";
                echo   $postTitle;
                echo "
                    </div>
                    <div class='dashboard-post-overview-text' onclick>";
                echo $postText;
                echo "
                    </div>
                <form method='POST'>
                    <input type='hidden' name='postIdInput' value='".$postId."'>
                    <button class='dashboard-post-overview-seeMore-btn' type='submit'>See more</button>   
                </form>
                    
                </div>
                ";
            }
            ?>
        </div>

    </div>
    <div class="dashboard-div-currentPost-column">
        <?php
            //if the button addPost was clicked, echo an interface for adding a new post
            if (isset($_POST['addPostInput'])) {
                unset($_SESSION['currentPost-dashboard']);

                echo "
                    <div class='post-full-dashboard'>
                        <div class='post-full-dashboard-id-div'>Add a new post</div>
                        <form class='post-full-dashboard-form' method='POST'>
                            <div class='post-full-dashboard-title'>
                                <p class='post-full-dashborad-input-heading'>Title</p>
                                <input class='post-full-dashboard-addPost-title-input' name='post-addPost-title-input'>
                            </div>
                            <div class='post-full-dashboard-text'>
                                <p class='post-full-dashborad-input-heading'>Text</p>
                                <textarea class='post-full-dashboard-addPost-text-textarea' name='post-addPost-text-textarea' cols='100' rows='5'></textarea>
                            </div>
                            <button class='post-full-dashboard-addPost-btn' type='submit'>Add post</button>
                        </form>
                        <form class='post-full-dashboard-cancel' method='POST'>
                            <input type='hidden' name='cancelAddPostBtn'>
                            <button class='post-full-dashboard-cancelAddPost-btn' type='submit'>Cancel</button>
                        </form>
                    </div>
                    ";
            }

            //if a post was clicked on the left, echo it (in input fields)
            if (isset ($_SESSION['currentPost-dashboard'])) {
                if ($_SESSION['currentPost-dashboard']['id'] != '') {
                    echo "
                    <div class='post-full-dashboard'>
                        <div class='post-full-dashboard-id-div'>Post ".$_SESSION['currentPost-dashboard']['id']."</div>
                        <form method='POST'>
                            <input type='hidden' name='deletePostInput' value='".$_SESSION['currentPost-dashboard']['id']."'>
                            <button class='post-dashboard-delete-btn' type='submit'>Delete</button>
                        </form>
                        <form class='post-full-dashboard-form' method='POST'>
                            <div class='post-full-dashboard-title'>
                                <p class='post-full-dashborad-input-heading'>Title</p>
                                <input class='post-full-dashboard-title-input' name='post-title-input' value='".$_SESSION['currentPost-dashboard']['title']."'>
                            </div>
                            <div class='post-full-dashboard-text'>
                                <p class='post-full-dashborad-input-heading'>Text</p>
                                <textarea class='post-full-dashboard-text-textarea' name='post-text-textarea' cols='100' rows='5'>".$_SESSION['currentPost-dashboard']['text']."</textarea>
                            </div>
                            <button class='post-full-dashboard-safeChanges-btn' type='submit'>Safe changes</button>
                        </form>
                        <form class='post-full-dashboard-cancel' method='POST'>
                            <input type='hidden' name='cancelChangesBtn'>
                            <button class='post-full-dashboard-cancel-btn' type='submit'>Cancel</button>
                        </form>
                    ";

                    echo "
                    <div class='post-comments-heading'>Comments</div>
                    ";

                    //display all comments of the current post
                    $rowsOfCommentsOfCurrentPost = mysqli_query($conn, "SELECT * FROM comments WHERE postId='".$_SESSION['currentPost-dashboard']['id']."';");
    
                    //if there are comments, display them
                    $numberOfComments = mysqli_num_rows($rowsOfCommentsOfCurrentPost);

                    if ($numberOfComments > 0) {
                        foreach ($rowsOfCommentsOfCurrentPost as $oneRow) {
                            echo "
                                <div class='comment-dashboard'>
                                    <div class='comment-dashboard-title'>".$oneRow['title']."</div>
                                    <div class='comment-dashboard-text'>".$oneRow['text']."</div>
                                    <form method='POST'>
                                        <input type='hidden' name='deleteCommentOfAPostInput' value='".$oneRow['id']."'>
                                        <button class='comment-dashboard-delete-btn' type='submit'>Delete</button>
                                    </form>
                                </div>
                            ";
                        }
                    } else {
                        echo "There are no comments regarding this post.";
                    }

                    echo "
                    </div> <!--post-full-dashboard-->
                    ";

                    

                } else {
                    echo "Click the 'See more'-button of a post on the left to edit the post.";
                }
            } else {
                echo "Click the 'See more'-button of a post on the left to edit the post.";
            }
        ?>
    </div>
</div>



</body>
</html>