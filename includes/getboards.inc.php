<!-- <?php

if ($_SERVER["REQUEST_METHOD"] == "get") {
    
    try {
        require_once "dbh.inc.php";

        $query = "SELECT * FROM boards WHERE users.username = ";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":post_title", $post_title);
        $stmt->bindParam(":post_text", $post_text);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":img", $img);
        $stmt->bindParam(":parent_id", $parent_id);
        $stmt->bindParam(":board_short", $board_short);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        $stmt = null;

    }  catch ( PDOException $e ) {
        die( "connection faild " . $e->getMessage() );
    }

} else {
    echo "error";
}
?> -->