
<div class="container">
    <table class="table">

      <tr>
        <th>Symbol</th>
        <th>Shares</th>
        <th>Price</th>
        <th>Current Value</th>
      </tr>

    <?php foreach ($positions as $position): ?>
    
        <tr>
            <td align="left"><?= $position["symbol"] ?></td>
            <td align="left"><?= $position["shares"] ?></td>
            <td align="left"><?= number_format($position["price"], 2) ?></td>
            <td align="left"><?= number_format($position["price"]*$position["shares"], 2) ?></td>
        </tr>

    <?php endforeach ?>
        

</table>
<?php    print("Current Balance : " . number_format($cash, 2));  ?>
</div>