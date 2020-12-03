<?php


namespace common\models;


use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;

/**
 * Class Area
 * @package common\models
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
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

    public $fileImage;

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
                ]
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'name_en', 'archsite_id'], 'required'],
            [['name', 'description'], 'string'],
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
        $scenarios[self::SCENARIO_CREATE] = ['name', 'description', 'image', 'lat', 'lng', 'archsite_id'];

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
            'lng' => 'Долгота'
        ];
    }

    public function findAllOfSite($id)
    {
        return self::find()->where(['archsite_id' => $id])->all();
    }
}