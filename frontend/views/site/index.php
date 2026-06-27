<?php

/* @var $this yii\web\View */


$this->registerCssFile('css/home.css?201903131429', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);

$this->title = Yii::$app->name;
?>

<?= $this->render('_banner') ?>

<p>
    <?= Yii::t('home', 'The Altai-Sayan mountain belt is a zone of concentration of amazing monuments of the prehistoric art - rock drawings. The most explored zones of the mountains of Southern Siberia are Altai, Tuva, Khakassia, Priangaria, the Baikal and Transbaikalia. Rock drawings were created here in various ways: painting, engraving, pecking, polishing, etc.') ?>
</p>
<p>
    <?= Yii::t('home', 'The most ancient images, apparently related to the end of the Paleolithic era, were found in the Altai, on the Ukok plateau (Kalgutinsky rudnik), in the upper reaches of the Lena (Shishkino). The main plot of these, isolated by stylistic and technological analysis, images is horses, bulls, rhinos and other animals.') ?>
</p>
<p>
    <?= Yii::t('home', 'Researchers make assumptions about the ancient age of the petroglyphs of the "Minusinsky style", highlighting the origins and specifics of the artistic traditions of the stone age. As a rule, these are images of people in horned headdresses, boats, elks, wild bulls and horses, argali, wild boars, bears, etc., caused mainly by pecking and painting. The layer of Neolithic drawings is represented by the petroglyphs of Altai (Kalbak-Tash), Khakassia (Shalabolino, Oglakhty), Baikal (Sagan-Zaba), rivers Angara and Lena.') ?>
</p>
<p>
    <?= Yii::t('home', 'Bright compositions and individual images of the Bronze Age are represented in Altai, Transbaikalia, Khakassia, and Tuva (anthropomorphic figures in dance, with weapons, chariots, fantastic creatures, predators, bulls, deer, horses). The drawings are made by various techniques – engraving, pecking, polishing. Often there are also drawings with mineral paint, called "Pisanitsa". The era of early iron includes compositions of real images of villages, hunting scenes, people, animals, domestic and battle scenes (monuments of Tagar culture in Khakassia).') ?>
</p>
<p>
    <?= Yii::t('home', 'The Middle Ages left wonderful engraved images in Altai and in the Baikal region, showing battle scenes, moving scenes, hunting scenes.') ?>
</p>
<p>
    <?= Yii::t('home', 'The study of the petroglyphs of Southern Siberia has a long history: starting with the work of the first academic expeditions of the 18th century, researchers from the East Siberian Department of the Imperial Russian Geographical Society, local amateur historians. The most comprehensive research is presented in the works of A. P. Okladnikov, Ya. A. Sher, A. I. Martynov, V. I. Molodin, M. A. Devlet, E. G. Devlet, D. G. Savinova, E. A. Miklashevich and other researchers of the ancient art of Siberia.') ?>
</p>

<h3><?= Yii::t('home', 'Publications')?></h3>

<ul class="piblications">
    <li>
        Kubarev V.D., Jacobson E. Siberie du Sud: K’albak-Tash I (Republique de l’Altai). Repertoire des Petroglyphes d’Asie Centrale. Paris, 1996. V. 3.
    </li>
    <li>
        <?= Yii::t('home', 'Devlet E.G., Devlet M.A. Myths in stone. The world of rock art of Russia. Moscow, 2005. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Devlet, M.A. Petroglyphs of Ulug-Khem. Moscow, 1976. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Kovtun I.V. Pictorial traditions of the Bronze Age of Central and North-West Asia. Novosibirsk, 2001. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Molodin V.I., Cheremisin D.V. The oldest rock paintings of the Ukok plateau. Novosibirsk, 1999. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Okladnikov A.P. Shishkinsky pisanitsy. Irkutsk, 1959. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Okladnikov A.P., Martynov A.I. Treasures of Tomsk writers. Moscow, 1972. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Okladnikov A.P., Zaporozhskaya V.D. Petroglyphs of Transbaikalia. Leningrad, 1969, 1970. Part 1, 2; (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Okladnikov A.P. Petroglyphs of the Angara, 1966. (in Russian)')?>
    </li>
    <li>
        <?= Yii::t('home', 'Pyatkin B.N., Martynov A.I. Shalabolinsky petroglyphs. Krasnoyarsk, 1985.')?>
    </li>
    <li>
        <?= Yii::t('home', 'Sher Ya.A. Petroglyphs of Central and Central Asia. Moscow-Leningrad, 1980.')?>
    </li>
</ul>