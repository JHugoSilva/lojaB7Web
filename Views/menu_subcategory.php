<?php foreach ($subs as $sub): ?>
    <li>
        <a href="<?= BASE_URL.'categories/enter/'.$sub['id'];?>">
            <?php for($q=0;$q<$level;$q++) echo '-- ';
                echo $sub['name'];
            ?>
        </a>
    </li>
    <?php
    if (count($sub['subs']) > 0) {
        $this->loadView('menu_subcategory', [
            'subs' => $sub['subs'],
            'level' => $level + 1
        ]);
    }
    ?>
<?php endforeach;?>