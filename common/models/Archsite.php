<?php

namespace common\models;

use Yii;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;
include_once "../../vendor/phpmorphy-0.3.7/src/common.php";

/**
 * Archsite model
 *
 * @property integer $id
 * @property string $index
 * @property string $registry_num
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $publication
 * @property string $publication_en
 * @property string $image
  * @property string $fileImage
 * @property float $lat
 * @property float $lng
  * @property integer $created_at
  * @property integer $updated_at
  * @property string $thumbnailImage,
 */
class Archsite extends ActiveRecord
{

    const DIR_IMAGE = 'storage/web/archsite';
    const SRC_IMAGE = '/storage/archsite';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;
    const THUMBNAIL_PREFIX = 'thumbnail_';
    const SCENARIO_CREATE = 'create';
    const COUNT_SYB = 500;

    public $fileImage;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'en' => 'English',
                ],
                'languageField' => 'locale',
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'archsite_id',
                'tableName' => "{{%archsite_language}}",
                'attributes' => [
                    'name',
                    'description',
                    'publication',
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en'], 'required'],
            [['name', 'description', 'publication'], 'string'],
            [['lat', 'lng'], 'double'],
            ['image', 'string'],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'description', 'publication', 'image', 'lat', 'lng', 'index', 'registry_num'];

        return $scenarios;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if ($this->validate() and !empty($this->fileImage)) {

            $path = self::basePath();

            if (!empty($this->image) and file_exists($path . '/' . $this->image)) {
                unlink($path . '/' . $this->image);

                if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->image)) {
                    unlink($path . '/' . self::THUMBNAIL_PREFIX . $this->image);
                }
            }

            FileHelper::createDirectory($path);

            $newName = md5(uniqid($this->id));
            $this->fileImage->saveAs($path . '/' . $newName . '.' . $this->fileImage->extension);
            $this->image = $newName . '.' . $this->fileImage->extension;

            $sizes = getimagesize($path . '/' . $newName . '.' . $this->fileImage->extension);
            if ($sizes[0] > self::THUMBNAIL_W) {
                Image::thumbnail($path . '/' . $newName . '.' . $this->fileImage->extension, self::THUMBNAIL_W, self::THUMBNAIL_H)
                    ->resize(new Box(self::THUMBNAIL_W, self::THUMBNAIL_H))
                    ->save($path . '/' . self::THUMBNAIL_PREFIX . $newName . '.' . $this->fileImage->extension, ['quality' => 80]);
            }

            $this->scenario = self::SCENARIO_CREATE;
            return $this->save();
        } else {
            return false;
        }
    }

    /**
     * label attr
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('model', 'Name in Russian'),
            'name_en' => Yii::t('model', 'Name in English'),
            'description' => Yii::t('model', 'Description in Russian'),
            'description_en' => Yii::t('model', 'Description in English'),
            'publication' => Yii::t('model', 'Publication'),
            'publication_en' => Yii::t('model', 'Publication in English'),
            'image' => Yii::t('model', 'Image'),
            'fileImage' => Yii::t('model', 'Image'),
            'index' => Yii::t('model', 'Index'),
            'registry_num' => Yii::t('model', 'State registry number'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetroglyphs()
    {
        $query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id']);
        $query->where(['deleted' => null])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }
        return $query;
    }

    /**
     * @return ActiveRecord[]
     */
    public function getAreas()
    {
        return Area::find()->where(['archsite_id'=>$this->id])->all();
    }

    public function getPetroglyphsWithoutArea()
    {
        $query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id']);
        $query->where(['deleted' => null])->andWhere(['area_id'=>null])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }
        return $query;
    }

    public function getPetroglyphsWithoutAreaCount()
    {
        $query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id']);
        $query->where(['deleted' => null])->andWhere(['area_id'=>null]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }
        return $query->count();
    }

    public function searchPetroglyphs($search)
    {
        $query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id'])->join('LEFT JOIN', 'petroglyph_language', 'petroglyph_language.petroglyph_id = petroglyph.id');
        $query->where(['deleted' => null])->andWhere(['locale' => Yii::$app->language])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }

        $dir = '../../vendor/phpmorphy-0.3.7/dicts';
        if (Yii::$app->language == "ru") $lang = 'ru_RU';
        else $lang = 'en_EN';
        $opts = array(
            'storage' => PHPMORPHY_STORAGE_FILE,
        );
        try {
            $morphy = new \phpMorphy($dir, $lang, $opts);
        } catch(phpMorphy_Exception $e) {
            die('Error occured while creating phpMorphy instance: ' . $e->getMessage());
        }
        $forms = $morphy->getAllForms($search);
        if (empty($forms)) $forms = $search;
        $query = $query->andWhere(['or',['or like', 'description', $forms], ['or like', 'name', $forms]]);
        return $query;
    }

    public function searchPetroglyphsWithoutArea($search)
    {
        $query = $this->hasMany(Petroglyph::className(), ['archsite_id' => 'id'])->join('LEFT JOIN', 'petroglyph_language', 'petroglyph_language.petroglyph_id = petroglyph.id');
        $query->where(['deleted' => null])->andWhere(['locale' => Yii::$app->language])->andWhere(['area_id' => null])->orderBy(['id' => SORT_DESC]);
        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }

        $dir = '../../vendor/phpmorphy-0.3.7/dicts';
        if (Yii::$app->language == "ru") $lang = 'ru_RU';
        else $lang = 'en_EN';
        $opts = array(
            'storage' => PHPMORPHY_STORAGE_FILE,
        );
        try {
            $morphy = new \phpMorphy($dir, $lang, $opts);
        } catch(phpMorphy_Exception $e) {
            die('Error occured while creating phpMorphy instance: ' . $e->getMessage());
        }
        $forms = $morphy->getAllForms($search);
        if (empty($forms)) $forms = $search;
        $query = $query->andWhere(['or',['or like', 'description', $forms], ['or like', 'name', $forms]]);
        return $query;
    }

        /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getThumbnailImage()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->image)) {
            return self::THUMBNAIL_PREFIX . $this->image;
        } else {
            return $this->image;
        }
    }

    /**
     * Удаляем файл перед удалением записи
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeDelete()
    {
        $baseDir = self::basePath();

        if (!empty($this->image) and file_exists($baseDir . '/' . $this->image)) {
            unlink($baseDir . '/' . $this->image);
        }

        return parent::beforeDelete();
    }

    /**
     * Устанавливает путь до директории
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public static function basePath()
    {
        $path = \Yii::getAlias('@' . self::DIR_IMAGE);

        // Создаем директорию, если не существует
        FileHelper::createDirectory($path);

        return $path;
    }
}