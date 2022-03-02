<?php

    include 'database/dbh.php';
    include 'header.php';
    
    //check if button see more of a Post was clicked, set up session currentPost and redirect to post.php
    if (isset($_POST['postIdInput'])) {
        //echo "$...['postIdInput'] is set";
        $_SESSION['currentPost'] = array('id' => '', 'title' => '', 'text' => '', 'date' => '');
        $_SESSION['currentPost']['id'] = $_POST['postIdInput'];
        //echo $_SESSION['currentPost'];

        //get row of posts which has the current Id
        $currentRowOfPosts = mysqli_query($conn, "SELECT * FROM posts WHERE id='".$_POST['postIdInput']."';");
        $currentRowOfPostsFetched = mysqli_fetch_assoc($currentRowOfPosts);

        //set up session currentPost and assign all values to it
        $_SESSION['currentPost'] = array('id' => '', 'title' => '', 'text' => '', 'date' => '');

        $_SESSION['currentPost']['id'] = $currentRowOfPostsFetched['id'];
        $_SESSION['currentPost']['title'] = $currentRowOfPostsFetched['title'];
        $_SESSION['currentPost']['text'] = $currentRowOfPostsFetched['text'];
        $_SESSION['currentPost']['date'] = $currentRowOfPostsFetched['date'];

        //redirect to post.php
        header('Location: post.php');
    }
?>

<body>
    <?php
    if (isset($_SESSION['user'])) {
        echo "<div class='index-greeting'>Hello, ".$_SESSION['user']['email']."!</div>";
        //display posts
        //get all row(s) of posts and check how many of them there are
        $sql = "SELECT * FROM posts;";
        $rowsOfPosts = mysqli_query($conn, $sql);

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

            $postPageName = 'post.php';

            echo "
            <div class='post-preview'>
                <div class='post-preview-title'>";
            echo   $postTitle;
            echo "
                </div>
                <div class='post-preview-text' onclick>";
            echo $postText;
            echo "
                </div>
            <form method='POST'>
                <input type='hidden' name='postIdInput' value='".$postId."'>
                <button class='post-preview-seeMore-btn' type='submit'>See more</button>   
            </form>
                
            </div>
            ";
        }
    }
    ?>
    <!-- <div class="post-preview">
        <div class="post-preview-title">
            A Title
        </div>
        <div class="post-preview-text" onclick>
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   
            Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.   
            Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   
            Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.   
            Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.   
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur
        </div>
        <form method="POST">
            <button class="post-preview-seeMore-btn" type="submit">See more</button>
        </form>

    </div> -->
<script>
        const postPreviewSeeMoreBtn = document.querySelector('.post-preview-seeMore-btn');
        postPreviewSeeMoreBtn.onclick = function ($idOfPost) {
            location.href='post.php';

        }
</script>
</body>
</html>