<div class="container">
    <table class="table">

      <tr>
        <th>Date & Time</th>
        <th>Symbol</th>
        <th>Action</th>
        <th>Shares</th>
        <th>At Price</th
      </tr>

    <?php foreach ($positions as $position): ?>
    
        <tr>
            <td align="left"><?= $position["time"] ?></td>
            <td align="left"><?= $position["symbol"] ?></td>
            <td align="left"><?= $position["action"] ?></td>
            <td align="left"><?= $position["shares"] ?></td>
            <td align="left"><?= number_format($position["price"], 2) ?></td>
        </tr>

    <?php endforeach ?>
        

</table>
