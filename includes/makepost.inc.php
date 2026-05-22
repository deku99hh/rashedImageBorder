<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $parent_id = !empty($_POST["parent_id"]) ? $_POST["parent_id"] : null;
    $board_short = $_POST["board_short"];
    $post_title = !empty($_POST["post_title"]) ? $_POST["post_title"] : null;
    $post_text = $_POST["post_text"];
    $username = !empty($_POST["username"]) ? $_POST["username"] : "Anonymous";
    $img = !empty($_POST["img"]) ? $_POST["img"] : null;

    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO posts (post_title, post_text, username, img, parent_id, board_short) 
        VALUES(:post_title, :post_text, :username, :img, :parent_id, :board_short);";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":post_title", $post_title);
        $stmt->bindParam(":post_text", $post_text);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":img", $img);
        $stmt->bindParam(":parent_id", $parent_id);
        $stmt->bindParam(":board_short", $board_short);

        $stmt->execute();
        $pdo = null;
        $stmt = null;

        header("Location: ../board.php?board=$board_short");

    }  catch ( PDOException $e ) {
        die( "connection faild " . $e->getMessage() );
    }

} else {
    header('Location: ../board.php');
}