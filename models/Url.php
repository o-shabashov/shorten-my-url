<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url".
 * @property integer $id
 * @property string  $source
 * @property string  $short
 */
class Url extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source'], 'required'],
            [['source'], 'url'],
            [
                'source',
                function ($attribute, $params) {
                    if (parse_url($this->$attribute, PHP_URL_HOST) === parse_url(\yii\helpers\Url::home(true), PHP_URL_HOST)
                    ) {
                        $this->addError($attribute, 'Unable to create short URL');
                    }
                },
            ],

            [['short'], 'string', 'max' => 100],
            [['short'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => Yii::t('app', 'ID'),
            'source' => Yii::t('app', 'Source URL'),
            'short'  => Yii::t('app', 'Short URL'),
        ];
    }

    /**
     * @inheritdoc
     * @return UrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UrlQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $length      = rand(4, 6);
            $this->short = substr(
                str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length
            );

            return true;
        } else {
            return false;
        }
    }

    public function getShortUrl()
    {
        return sprintf('%s/%s', \yii\helpers\Url::base(true), $this->short);
    }
}
