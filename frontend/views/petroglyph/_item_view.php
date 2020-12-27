<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Petroglyph;
?>

<a href="<?= Url::to(['petroglyph/view', 'id' => $model->id]) ?>" class="petroglyph-item">
    <div class="row">
        <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $model->thumbnailImage, ['class' => 'img-responsive']) ?>
    </div>
    <h3>
        <?if ($model->archsite) echo $model->archsite->name . ". " ?><?= $model->name ?>
    </h3>
</a>
