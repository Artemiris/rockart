<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "petroglyph_three_d".
 *
 * @property int $id
 * @property int $petroglyph_id
 * @property string $url
 *
 * @property string $name
 * @property string $name_en
 * @property Petroglyph $petroglyph
 */
class PetroglyphThreeD extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'petroglyph_three_d';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petroglyph_id', 'name', 'name_en', 'url'], 'required'],
            [['name', 'name_en'], 'string'],
            [['url'], 'string', 'max' => 255],
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
                'langForeignKey' => 'petroglyph_three_d_id',
                'tableName' => "{{%petroglyph_three_d_language}}",
                'attributes' => [
                    'name',
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
            'url' => Yii::t('model', 'Link'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetroglyph()
    {
        return $this->hasOne(Petroglyph::className(), ['id' => 'petroglyph_id']);
    }
}
