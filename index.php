<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rashedImageBorder</title>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #0f111a;
        color: #ffffff;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    .linkcontainer{
        margin-top: 2rem;
    }

    body > flex, .boards-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        max-width: 800px;
        margin-bottom: 50px;
        padding: 20px;
        /* background: #161925; */
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }

    a {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 8px 16px;
        background-color: #1f2335;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    a:hover {
        color: #ffffff;
        background-color: #4f46e5;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        border-color: #818cf8;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-top: 20%;
        /* filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5)); */
    }
</style>

</head>
<body>
    <div class="linkcontainer">

    <?php 
    try {
        require_once "includes/dbh.inc.php";

        $query = "SELECT * FROM boards;";

        $stmt = $pdo->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        $stmt = null;

        // print_r( $result[0] );

        foreach($result as $oneboard){
            $board_name = $oneboard['board_name'];
            $board_short = $oneboard['board_short'];
            echo "<a href='board.php?board=$board_short'>[$board_name] </a>";
        };

    }  catch ( PDOException $e ) {
        die( "connection faild " . $e->getMessage() );
    }

    ?>

    </div>

    <img src="https://wizchan.org/static/wizardchan.png" alt="">
</body>
</html>