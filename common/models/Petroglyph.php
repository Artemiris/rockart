<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use thamtech\uuid\helpers\UuidHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "petroglyph".
 *
 * @property int $id
 * @property string $uuid
 * @property string $lat
 * @property string $lng
 * @property string $image
 * @property string $im_dstretch
 * @property string $im_drawing
 * @property string $im_reconstruction
 * @property string $im_overlay
 * @property string $orientation_x
 * @property string $orientation_y
 * @property string $orientation_z
 * @property int $method_id
 * @property int $culture_id
 * @property int $epoch_id
 * @property int $archsite_id
 * @property int $deleted
 * @property int $public
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $index
 *
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $publication
 * @property string $publication_en
 * @property string $technical_description
 * @property string $technical_description_en
 *
 * @property Culture $culture
 * @property Epoch $epoch
 * @property Method $method
 * @property PetroglyphImage[] $images
 * @property PetroglyphThreeD[] $threeD
 * @property Composition[] $compositions
 * @property string $thumbnailImage
 * @property string $thumbnailImDstretch
 * @property string $thumbnailImDrawing
 * @property string $thumbnailImReconstr
 * @property string $thumbnailImOverlay
 */
class Petroglyph extends \yii\db\ActiveRecord
{

    const DIR_IMAGE = 'storage/web/petroglyph';
    const SRC_IMAGE = '/storage/petroglyph';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;
    const THUMBNAIL_PREFIX = 'thumbnail_';

    public $fileImage;
    public $fileDstr;
    public $fileDraw;
    public $fileReconstr;
    public $fileOverlay;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'petroglyph';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en'], 'required'],
            [['name', 'name_en', 'description', 'description_en', 'index', 'technical_description', 'publication'], 'string'],
            [['lat', 'lng', 'orientation_x', 'orientation_y', 'orientation_z'], 'number'],
            [['method_id', 'culture_id', 'epoch_id', 'deleted', 'public'], 'integer'],
            [['uuid'], 'string', 'max' => 64],
            [['image', 'im_dstretch', 'im_drawing', 'im_reconstruction', 'im_overlay'], 'string', 'max' => 255],
            [['culture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Culture::className(), 'targetAttribute' => ['culture_id' => 'id']],
            [['epoch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Epoch::className(), 'targetAttribute' => ['epoch_id' => 'id']],
            [['method_id'], 'exist', 'skipOnError' => true, 'targetClass' => Method::className(), 'targetAttribute' => ['method_id' => 'id']],
            [['style_id'], 'exist', 'skipOnError' => true, 'targetClass' => Style::className(), 'targetAttribute' => ['style_id' => 'id']],
            [['archsite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Archsite::className(), 'targetAttribute' => ['archsite_id' => 'id']],
            [['fileImage', 'fileDraw', 'fileReconstr', 'fileOverlay', 'fileDstr'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
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
                'langForeignKey' => 'petroglyph_id',
                'tableName' => "{{%petroglyph_language}}",
                'attributes' => [
                    'name',
                    'description',
                    'publication',
                    'technical_description',
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
            'lat' => Yii::t('model', 'Latitude'),
            'lng' => Yii::t('model', 'Longitude'),
            'image' => Yii::t('model', 'Image'),
            'im_dstretch' => Yii::t('model', 'Image DStretch'),
            'im_drawing' => Yii::t('model', 'Drawing image'),
            'im_reconstruction' => Yii::t('model', 'Reconstruction image'),
            'im_overlay' => Yii::t('model', 'Image overlay'),
            'fileImage' => Yii::t('model', 'Image'),
            'fileDstr' => Yii::t('model', 'Image DStretch'),
            'fileDraw' => Yii::t('model', 'Drawing image'),
            'fileReconstr' => Yii::t('model', 'Reconstruction image'),
            'fileOverlay' => Yii::t('model', 'Image overlay'), 
            'method_id' => Yii::t('model', 'Method'),
            'style_id' => Yii::t('model', 'Style'),
            'culture_id' => Yii::t('model', 'Culture'),
            'epoch_id' => Yii::t('model', 'Epoch'),
            'archsite_id' => Yii::t('model', 'Archsite'),
            'public' => Yii::t('model', 'Published'),
            'index' => Yii::t('model', 'Index'),
            'technical_description' => Yii::t('model', 'Technical description'),
            'technical_description_en' => Yii::t('model', 'Technical description in English'),
            'publication' => Yii::t('model', 'Publication'),
            'publication_en' => Yii::t('model', 'Publication in English'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCulture()
    {
        return $this->hasOne(Culture::className(), ['id' => 'culture_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEpoch()
    {
        return $this->hasOne(Epoch::className(), ['id' => 'epoch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMethod()
    {
        return $this->hasOne(Method::className(), ['id' => 'method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(Style::className(), ['id' => 'style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchsite()
    {
        return $this->hasOne(Archsite::className(), ['id' => 'archsite_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(PetroglyphImage::className(), ['petroglyph_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThreeD()
    {
        return $this->hasMany(PetroglyphThreeD::className(), ['petroglyph_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompositions()
    {
        return $this->hasMany(Composition::className(), ['petroglyph_id' => 'id']);
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if ($this->validate() and (!empty($this->fileImage)
                                    or !empty($this->fileDstr)
                                    or !empty($this->fileDraw)
                                    or !empty($this->fileReconstr)
                                    or !empty($this->fileOverlay))) {

            $path = self::basePath();
            $imagesPull = array(
                'Original' => array (
                    'fileName' => 'fileImage',
                    'file' => $this->fileImage,
                    'fieldName' => 'image',
                ),
                'Dstretch' => array (
                    'fileName' => 'fileDstr',
                    'file' => $this->fileDstr,
                    'fieldName' => 'im_dstretch',
                ),
                'Drawing' => array (
                    'fileName' => 'fileDraw',
                    'file' => $this->fileDraw,
                    'fieldName' => 'im_drawing',
                ),
                'Reconstruction' => array (
                    'fileName' => 'fileReconstr',
                    'file' => $this->fileReconstr,
                    'fieldName' => 'im_reconstruction',
                ),
                'Overlay' => array (
                    'fileName' => 'fileOverlay',
                    'file' => $this->fileOverlay,
                    'fieldName' => 'im_overlay',
                ),
            );
            
            if(!empty($imagesPull)){

                foreach($imagesPull as $key=>$item){
                    $im = $item['file'];
                    $fieldFile = $item['fileName'];
                    $fieldIm = $item['fieldName'];
                    if($im == null) continue;
                    if (!empty($im) and file_exists($path . '/' . $im)) {
                        unlink($path . '/' . $im);

                        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $im)) {
                            unlink($path . '/' . self::THUMBNAIL_PREFIX . $im);
                        }
                    }

                    FileHelper::createDirectory($path);

                    $newName = md5(uniqid($this->id));
                    $im->saveAs($path . '/' . $newName . '.' . $im->extension);
                    $this->$fieldIm = $newName . '.' . $im->extension;

                    $sizes = getimagesize($path . '/' . $newName . '.' . $im->extension);
                    if ($sizes[0] > self::THUMBNAIL_W) {
                        $width = self::THUMBNAIL_W;
                        $height = $width * $sizes[1] / $sizes[0];
                        Image::thumbnail($path . '/' . $newName . '.' . $im->extension, $width, $height)
                            ->resize(new Box($width, $height))
                            ->save($path . '/' . self::THUMBNAIL_PREFIX . $newName . '.' . $im->extension, ['quality' => 80]);
                    }
                    
                    $this->$fieldFile = false;
                }
            }
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
     * @return string
     * @throws \yii\base\Exception
     */
    public function getThumbnailImDstretch()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->im_dstretch)) {
            return self::THUMBNAIL_PREFIX . $this->im_dstretch;
        } else {
            return $this->im_dstretch;
        }
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getThumbnailImDrawing()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->im_drawing)) {
            return self::THUMBNAIL_PREFIX . $this->im_drawing;
        } else {
            return $this->im_drawing;
        }
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getThumbnailImReconstr()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->im_reconstruction)) {
            return self::THUMBNAIL_PREFIX . $this->im_reconstruction;
        } else {
            return $this->im_reconstruction;
        }
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getThumbnailImOverlay()
    {
        $path = self::basePath();

        if (file_exists($path . '/' . self::THUMBNAIL_PREFIX . $this->im_overlay)) {
            return self::THUMBNAIL_PREFIX . $this->im_overlay;
        } else {
            return $this->im_overlay;
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
        $query = Petroglyph::find()->joinWith('petroglyph_language');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public function beforeSave($insert)
    {
        if (empty($this->uuid)) {
            $this->uuid = UuidHelper::uuid();
        }
        return parent::beforeSave($insert);
    }
}
