<?php
/* @var $archsite Archsite */

use common\models\Archsite;
use yii\helpers\Html;

?>

    <h1><?= $archsite->name ?></h1>

<?php if (!empty($archsite->image)): ?>
    <?=Html::img(Archsite::SRC_IMAGE . '/' . $archsite->thumbnailImage)?>
<?php endif; ?>

<?php if (!empty($area->description)): ?>
    <h3><?= Yii::t('app', 'Description') ?></h3>
    <?= $archsite->description ?>
<?php endif; ?>

<?php if (!empty($archsite->publication)): ?>
    <h3><?= Yii::t('app', 'Publications') ?></h3>
    <?= $archsite->publication ?>
<?php endif; ?>