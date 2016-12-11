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
        render("buy_form.php", ["cash" => $cash, "title" => "Buy"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
        if(!empty($stock) && preg_match("/^\d+$/", $_POST["shares"])) {

            $shares = $_POST["shares"];
            $reduce_cash = $shares*$stock["price"];
            if ($reduce_cash <= $cash) {
                if (CS50::query("SELECT * FROM portfolio WHERE user_id = $id AND symbol = ?", strtoupper($stock["symbol"]))) {
                    CS50::query("INSERT INTO portfolio (user_id, symbol, shares) VALUES($id, ? , $shares) ON DUPLICATE KEY UPDATE shares = shares + $shares", $stock["symbol"]);
                }
                
                else {
                    CS50::query("INSERT INTO portfolio (user_id, symbol, shares) VALUES($id, ? , $shares)", strtoupper($stock["symbol"]));
                }
                CS50::query("UPDATE users SET cash = cash - $reduce_cash WHERE id = ?", $id);
                CS50::query("INSERT INTO history (user_id, symbol, action, shares, price) VALUES($id, ? , 'buy', $shares , ?)", strtoupper($stock["symbol"]), $stock["price"]);
                redirect("/");
            }
            else
                apologize("Insufficient Balance");
        }
        else
            apologize("Invalid Stock Name");
    }
?>