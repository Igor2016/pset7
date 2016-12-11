<?php

    // configuration
    require("../includes/config.php"); 
    
   
    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $userRow = CS50::query("SELECT * FROM users WHERE id = ?", $id);
        $cash = $userRow[0]["cash"];
        $positions = [];
        $rows = CS50::query("SELECT * FROM portfolio WHERE user_id = ?", $id);
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "symbol" => $row["symbol"]
                ];
            }
        }
    }
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["positions" => $positions, "cash" => $cash, "title" => "Sell"]);
    }
    

    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
        if(!empty($stock)) {
            $del_row = CS50::query("SELECT * FROM portfolio WHERE user_id = $id AND symbol = ?", $stock["symbol"]);
            $no_shares = $del_row[0]["shares"];
            $add_cash = $no_shares*$stock["price"];
            CS50::query("DELETE FROM portfolio WHERE user_id = $id AND symbol = ?", $stock["symbol"]);
            CS50::query("UPDATE users SET cash = cash + $add_cash WHERE id = ?", $id);
            CS50::query("INSERT INTO history (user_id, symbol, action, shares, price) VALUES($id, ? , 'sell', $no_shares, ?)", $stock["symbol"], $stock["price"]);

            redirect("/");
        }
        else
            apologize("Invalid Stock Symbol");
    }
?>