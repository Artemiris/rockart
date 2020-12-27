<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $title ?></h3>
    </div>
    <?php if (!empty($data)): ?>
        <ul class="list-group">
            <?php foreach ($data as $datum): ?>
                <li class="list-group-item">
                    <?= $datum ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>