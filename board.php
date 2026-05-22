<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $board = $_GET['board'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>board</title>
</head>
<body>
    <form action="includes/makepost.inc.php" method="POST">

        <input type="hidden" name="board_short" value="<?php echo $board; ?>">
        <input type="text" name="post_title" placeholder="post_title" required>
        <input type="text" name="post_text" placeholder="post_text" required>
        <input type="text" name="username" placeholder="username">

        <input type="file" id="myfile" name="myfile">

        <button type="submit">submit</button>

    </form>


        <?php
    try {
        require_once "includes/dbh.inc.php";

        $query = "SELECT * FROM posts WHERE board_short = :board";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":board", $board);

        $stmt->execute();

        $allposts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        $stmt = null;

    }  catch ( PDOException $e ) {
        die( "connection faild " . $e->getMessage() );
    }

        ?>

        <?php
            // print_r($result);

        foreach($allposts as $post){

        if (!$post['parent_id']) {
            
            $post_id = $post['id'];
            $post_title = $post['post_title'];
            $post_text = $post['post_text'];
            $username = !empty($post["username"]) ? $post["username"] : "Anonymous";
            $img = $post['img'];
            $comments = "";
    
            foreach($allposts as $comment){
                if ($comment['parent_id'] == $post['id']) {
                    $comment_post_title = $comment['post_title'];
                    $comment_post_text = $comment['post_text'];
                    $comment_username = !empty($comment["username"]) ? $comment["username"] : "Anonymous";

                    $comment_html = <<<"comment"
                        <div class="comment">
                            <img src="">
                            <div class="about">
                                <h5 class="post_title">$comment_post_title</h5>
                                <h5 class="username">$comment_username</h5>
                            </div>
                            <div class="content">
                                <p class="post_text">
                                    $comment_post_text
                                </p>
                            </div>

                        </div>
                    comment;
                    $comments = $comments . $comment_html;

                }
            }

            $html = <<<"EOT"
<div class="thread">
    <div class="main">
        <img src="">
        <div class="about">
            <h5 class="post_title">$post_title</h5>
            <h5 class="username">$username</h5>
        </div>
        <div class="content">
            <p class="post_text">$post_text</p>
        </div>
    </div>
    <form action="includes/makepost.inc.php" method="POST">
        <input type="hidden" name="board_short" value="$board">
        <input type="hidden" name="parent_id" value="$post_id">
        <input type="text" name="post_title" placeholder="post_title" required>
        <input type="text" name="post_text" placeholder="post_text" required>
        <input type="text" name="username" placeholder="username">
        <input type="file" name="myfile">
        <button type="submit">submit</button>
        
    </form>
    $comments
</div>
<hr>
EOT;
    
            echo $html;

        }    
        }
        ?>
        
</body>
</html>