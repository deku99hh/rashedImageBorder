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

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e4e9ff;
        /* color: #ffffff; */
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    hr {
        border: black solid 1;
        width: 75%;
    }

    .main-form {
        background-color: #161925;
        max-width: 600px;
        margin: 0 auto 40px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border: 1px solid #2d3748;
    }

    .main-form h3 {
        margin-top: 0;
        color: #4f46e5;
        border-bottom: 1px solid #2d3748;
        padding-bottom: 10px;
    }

    input[type="text"], textarea {
    /* width: 100%; */
    padding: 10px;
    margin-bottom: 12px;
    /* background-color: #1f2335; */
    border: 1px solid #1a3b7100;
    border-radius: 6px;
    color: #fff;
    box-sizing: border-box;
    font-size: 0.95rem;
    }
    input[type="text"]:focus {
        border-color: #4f46e5;
        outline: none;
    }

    input[type="file"] {
        margin-bottom: 15px;
        /* color: #a0aec0; */
        display: block;
    }

    button {
        /* background-color: #4f46e5; */
        /* color: white; */
        /* border: none; */
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        display: inline-block;
        font-weight: 600;
        transition: background 0.2s;
    }

    button:hover {
        background-color: #4338ca;
    }

    .threads-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .thread {
        /* background-color: #161925; */
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 8px;
        /* border-left: 4px solid #4f46e5; */
        /* box-shadow: 0 2px 8px rgba(0,0,0,0.2); */
    }

    .main-post {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .post-image {
        width: 80px;
        height: 80px;
        background-color: #1f2335;
        border-radius: 6px;
        object-fit: cover;
    }

    .post-data {
        flex: 1;
    }

    .about {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 8px;
    }

    .post_title {
        margin: 0;
        font-size: 1.1rem;
        color: #2635c5;
    }

    .username {
        margin: 0;
        font-size: 0.9rem;
        color: #009126;
        font-weight: normal;
    }

    .post_text {
        margin: 0;
        /* color: #cbd5e1; */
        line-height: 1.5;
    }

    .reply-form {
        background-color: #1f2335;
        padding: 15px;
        border-radius: 6px;
        margin: 15px 0 15px 40px;
    }

    .reply-form .input-group {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .reply-form input[type="text"] {
        margin-bottom: 0;
    }

    .comment {
        display: flex;
        /* gap: 12px; */
        /* background-color: #f2f2f2; */
        padding: 12px;
        border-radius: 6px;
        /* margin-left: 40px; */
        margin-top: 10px;
        /* border: 1px solid #2d3748; */
    }

    .comment .username {
        color: #fbbf24;
    }
</style>

</head>
<body>
     <br> <br> <br>
    <form action="includes/makepost.inc.php" method="POST">

        <input type="hidden" name="board_short" value="<?php echo $board; ?>">
        <label for="post_title">post_title</label>
        <input type="text" name="post_title" placeholder="post_title" required> <br>
        <label for="post_text">post_text</label>
        <input type="text" name="post_text" placeholder="post_text" required> <br>
        <label for="username">username</label>
        <input type="text" name="username" placeholder="username"> <br>

        <input type="file" id="myfile" name="myfile">

        <button type="submit">submit</button>

    </form>
     <br>

<hr>

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
                            <img class="post_image" src="">
                                <div class="post-data">
                                <div class="about">
                                    <h5 class="post_title">$comment_post_title</h5>
                                    <h5 class="username">$comment_username</h5>
                                </div>
                                <p class="post_text">$comment_post_text</p>
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
        <input type="text" name="post_title" placeholder="comment_title" required>
        <input type="text" name="post_text" placeholder="comment_text" required>
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