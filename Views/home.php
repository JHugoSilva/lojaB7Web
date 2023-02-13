<div class="row">
    <?php $a = 0; ?>
    <?php foreach($list as $product_item): ?>
    <div class="col-sm-4">
        <div class="product_item">
            <?php $this->loadView('product_item', $product_item); ?>
        </div>
        <?php
        if ($a >= 2) {
            $a = 0;
            echo '</div><div class="row">';
        } else {
            $a++;
        }
        ?>
    </div>
    <?php endforeach; ?>
</div>
<div class="paginationArea">
    <?php for($q=1; $q <= $numberOfPages; $q++): ?>
        <div class="paginationItem <?php echo ($currentPage == $q) ? 'pag_active': '';?>">
            <a href="<?= BASE_URL; ?>?p=<?= $q; ?>">
                <?= $q; ?>
            </a>
        </div>
    <?php endfor;?>
</div>