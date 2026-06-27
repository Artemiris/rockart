<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "petroglyph_image".
 *
 * @property int $id
 * @property int $petroglyph_id
 * @property string $file
 *
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $thumbnailImage
 * @property Petroglyph $petroglyph
 */
class PetroglyphImage extends \yii\db\ActiveRecord
{

    const DIR_IMAGE = 'storage/web/petroglyph_image';
    const SRC_IMAGE = '/storage/petroglyph_image';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;
    const THUMBNAIL_PREFIX = 'thumbnail_';

    public $fileImage;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'petroglyph_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petroglyph_id'], 'required'],
            [['name', 'name_en', 'description', 'description_en'], 'string'],
            [['file'], 'string', 'max' => 255],
            [['petroglyph_id'], 'exist', 'skipOnError' => true, 'targetClass' => Petroglyph::className(), 'targetAttribute' => ['petroglyph_id' => 'id']],
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
                'langForeignKey' => 'petroglyph_image_id',
                'tableName' => "{{%petroglyph_image_language}}",
                'attributes' => [
                    'name',
                    'description',
                ]
            ],
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('model', 'Name in Russian'),
            'name_en' => Yii::t('model', 'Name in English'),
            'description' => Yii::t('model', 'Description in Russian'),
            'description_en' => Yii::t('model', 'Description in English'),
            'file' => Yii::t('model', 'Image'),
            'fileImage' => Yii::t('model', 'Image'),
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if ($this->validate() and !empty($this->fileImage)) {

            $path = self::basePath();

            if (!empty($this->file) and file_exists($path . '/' . $this->file)) {
                unlink($path . '/' . $this->file);

                if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->file)) {
                    unlink($path . '/' . self::THUMBNAIL_PREFIX . $this->file);
                }
            }

            FileHelper::createDirectory($path);

            $newName = md5(uniqid($this->id));
            $this->fileImage->saveAs($path . '/' . $newName . '.' . $this->fileImage->extension);
            $this->file = $newName . '.' . $this->fileImage->extension;

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
     * @return \yii\db\ActiveQuery
     */
    public function getPetroglyph()
    {
        return $this->hasOne(Petroglyph::className(), ['id' => 'petroglyph_id']);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getThumbnailImage()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->file)) {
            return self::THUMBNAIL_PREFIX . $this->file;
        } else {
            return $this->file;
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

        if (!empty($this->file) and file_exists($baseDir . '/' . $this->file)) {
            unlink($baseDir . '/' . $this->file);

            if (file_exists($baseDir . '/' . self::THUMBNAIL_PREFIX . $this->file)) {
                unlink($baseDir . '/' . self::THUMBNAIL_PREFIX . $this->file);
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
}
