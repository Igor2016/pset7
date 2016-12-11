<?php

    // configuration
    require("../includes/config.php"); 

    // render portfolio
    $positions = [];
    $id = $_SESSION["id"];
    $rows = CS50::query("SELECT * FROM portfolio WHERE user_id = ?", $id);
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"]
            ];
        }
    }
    $userRow = CS50::query("SELECT * FROM users WHERE id = ?", $id);
    $cash = $userRow[0]["cash"];
    render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);

?>
