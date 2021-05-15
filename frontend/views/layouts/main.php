<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\Lang;
use frontend\widgets\AuthPanel;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);

    $menuItems = [
        ['label' => Yii::t('app', 'Petroglyphs'), 'url' => ['petroglyph/index']],
        ['label' => Yii::t('app', 'Sites'), 'url' => ['archsite/index']]
    ];
    ?>


    <?php

    if (!Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Map'), 'url' => ['map/index']];
    }

    if (Yii::$app->user->can('manager')) {
        $menuItems[] = ['label' => Yii::t('app', 'Management'), 'url' => ['manager/index']];
    }

    if (Yii::$app->user->can('admin')) {
        $menuItems[] = ['label' => Yii::t('app', 'Admin panel'), 'url' => '/admin'];
    }
    ?>

    <?php
    $menuLang = (new Lang)->run([
        'widget_type' => 'classic', // classic or selector
        'image_type' => 'rounded', // classic or rounded
        'width' => '18',
    ]);

    $menuItems = array_merge($menuItems, $menuLang);
    ?>


    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]) ?>

    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => ['label' => (Yii::$app->user->isGuest ?
            '<li>' . AuthPanel::widget() . '</li>' :
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-primary logout', 'style' => 'margin-top: 10px; margin-left: 10px;']
            )
            . Html::endForm()
            . '</li>'
        )],
        'encodeLabels' => false,
    ]);
    ?>

    <?php NavBar::end(); ?>

    <div class="container">
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p>
            &copy;
            <a href="https://www.nsu.ru/n/" target="_blank"><?= Yii::t('app', 'Novosibirsk State University') ?></a>
            ↦
            <a href="http://artemir.nsu.ru/" target="_blank"><?= Yii::t('app', 'Prehistoric Art in Eurasia Lab') ?></a>
        </p>
        <p><?= Yii::t('app', 'Project supported by RSF #18-78-10079') ?> </p>
    </div>
</footer>

<?= $this->render('_counter') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
