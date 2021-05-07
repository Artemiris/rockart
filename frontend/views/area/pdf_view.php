<?php
/* @var $area Area */

use common\models\Archsite;
use common\models\Area;
use yii\helpers\Html;

?>

<h1><?= $archsiteName = Archsite::find()->where(['id'=>$area->archsite_id])->one()->name . '. ' . $area->name ?></h1>

<?php if (!empty($area->image)): ?>
    <?=Html::img(Area::SRC_IMAGE . '/' . $area->thumbnailImage)?>
<?php endif; ?>

<?php if (!empty($area->description)): ?>
    <h3><?= Yii::t('app', 'Description') ?></h3>
    <?= $area->description ?>
<?php endif; ?>

<?php if (!empty($area->publication)): ?>
    <h3><?= Yii::t('app', 'Publications') ?></h3>
    <?= $area->publication ?>
<?php endif; ?>
