<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "composition".
 *
 * @property int $id
 * @property string $image
 * @property string $index
 * @property int $petroglyph_id
 * @property string $description
 * @property string $description_en
 * @property Petroglyph $petroglyph
 */
class Composition extends \yii\db\ActiveRecord
{
    const DIR_IMAGE = 'storage/web/composition';
    const SRC_IMAGE = '/storage/composition';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;
    const THUMBNAIL_PREFIX = 'thumbnail_';

    public $fileImage;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'composition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petroglyph_id'], 'required'],
            [['petroglyph_id'], 'integer'],
            [['description', 'description_en', 'index'], 'string'],
            [['image'], 'string', 'max' => 255],
            [['petroglyph_id'], 'exist', 'skipOnError' => true, 'targetClass' => Petroglyph::className(), 'targetAttribute' => ['petroglyph_id' => 'id']],
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
                'langForeignKey' => 'composition_id',
                'tableName' => "{{%composition_language}}",
                'attributes' => [
                    'description',
                ]
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image' => Yii::t('model', 'Image'),
            'index' => Yii::t('model', 'Index'),
            'description' => Yii::t('model', 'Description in Russian'),
            'description_en' => Yii::t('model', 'Description in English'),
            'petroglyph_id' => Yii::t('model', 'Petroglyph'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetroglyph()
    {
        return $this->hasOne(Petroglyph::className(), ['id' => 'petroglyph_id']);
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
                $width = self::THUMBNAIL_W;
                $height = $width * $sizes[1] / $sizes[0];
                Image::thumbnail($path . '/' . $newName . '.' . $this->fileImage->extension, $width, $height)
                    ->resize(new Box($width, $height))
                    ->save($path . '/' . self::THUMBNAIL_PREFIX . $newName . '.' . $this->fileImage->extension, ['quality' => 80]);
            }

            $this->fileImage = false;
            return $this->save();
        } else {
            return false;
        }
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

            if (file_exists($baseDir . '/' . self::THUMBNAIL_PREFIX . $this->image)) {
                unlink($baseDir . '/' . self::THUMBNAIL_PREFIX . $this->image);
            }
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

    public function search($params)
    {
        $query = Petroglyph::find()->joinWith('composition_language');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        return $dataProvider;
    }
}
