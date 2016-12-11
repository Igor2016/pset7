<form action="sell.php" method="post">
    <fieldset>
        <div class="form-group">
            <select class="form-control" name="symbol">
                <?php foreach ($positions as $position): ?>
                    <option value= <?= $position["symbol"] ?> > <?= $position["symbol"] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-tag"></span>
                Sell
            </button>
        </div>
    </fieldset>
</form>

<?php    print("Current Balance : " . number_format($cash, 2));  ?>