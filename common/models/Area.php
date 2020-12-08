<?php


namespace common\models;


use Imagine\Image\Box;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * Class Area
 * @package common\models
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $publication
 * @property string $publication_en
 * @property integer $archsite_id
 * @property double $lat
 * @property double $lng
 * @property string $image
 */
class Area extends \yii\db\ActiveRecord
{
    const DIR_IMAGE = 'storage/web/area';
    const SRC_IMAGE = '/storage/area';
    const SCENARIO_CREATE = 'create';
    const THUMBNAIL_PREFIX = 'thumbnail_';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;

    public $fileImage;

    private static function basePath()
    {
        $path = \Yii::getAlias('@' . self::DIR_IMAGE);

        FileHelper::createDirectory($path);

        return $path;
    }

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
                'langForeignKey' => 'area_id',
                'tableName' => '{{%area_language}}',
                'attributes' => [
                    'name',
                    'description',
                    'publication'
                ]
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'name_en', 'archsite_id'], 'required'],
            [['name', 'description','publication'], 'string'],
            [['lat', 'lng'], 'double'],
            ['image', 'string'],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'description', 'publication', 'image', 'lat', 'lng', 'archsite_id'];

        return $scenarios;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'name_en' => 'Название на английском',
            'description' => 'Описание',
            'description_en' => 'Описание на английском',
            'image' => 'Изображение',
            'fileImage' => 'Изображение',
            'archsite_id' => 'Памятник',
            'lat' => 'Широта',
            'lng' => 'Долгота',
            'publication' => 'Публикации',
            'publication_en' => 'Публикации на английском'
        ];
    }

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

    public function getThumbnailImage()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->image)) {
            return self::THUMBNAIL_PREFIX . $this->image;
        } else {
            return $this->image;
        }
    }

    public static function findAllOfSite($id)
    {
        return self::find()->where(['archsite_id' => $id])->all();
    }

    public function beforeDelete()
    {
        $baseDir = self::basePath();

        if (!empty($this->image) and file_exists($baseDir . '/' . $this->image)) {
            unlink($baseDir . '/' . $this->image);
        }

        return parent::beforeDelete();
    }
}