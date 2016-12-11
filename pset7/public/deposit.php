<?php

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("deposit_form.php", ["title" => "Deposit"]);
    }
    
     else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["cash"]))
            apologize("You must provide deposit cash");
            
        else if(isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
            $cash = $_POST["cash"];
            CS50::query("UPDATE users SET cash = cash + $cash WHERE id = ?", $id);
            redirect("/");
        }
    }
?>