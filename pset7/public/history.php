<?php
    // configuration
    require("../includes/config.php"); 

    // render portfolio
    $positions = [];
    $id = $_SESSION["id"];
    $rows = CS50::query("SELECT * FROM history WHERE user_id = ?", $id);
    foreach ($rows as $row)
    {
        $positions[] = [
            "time" => $row["timestamp"],
            "price" => $row["price"],
            "shares" => $row["shares"],
            "symbol" => $row["symbol"],
            "action" => $row["action"]
        ];
    }
    render("transac_history.php", ["positions" => $positions, "title" => "History"]);

?>