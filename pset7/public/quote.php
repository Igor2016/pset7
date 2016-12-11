<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "Look Up"]);
    }
    
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        $s = lookup($_POST["symbol"]);
        if(!empty($s))
            render("quote.php", ["stock" => $s]);
        else
            apologize("Invalid Stock Symbol");
    }
?>