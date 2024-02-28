<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Модель Phone представляет собой телефонный номер, принадлежащий одному человеку
 * @property int $id идентификатор телефона
 * @property int $person_id идентификатор человека, которому принадлежит телефон
 * @property string $number телефонный номер в формате +7 (NNN) NN-NNN-NN
 * @property Person $person человек, которому принадлежит телефон
 */
class Phone extends ActiveRecord
{
    /**
     * Возвращает название таблицы в базе данных
     * @return string
     */
    public static function tableName()
    {
        return 'phones';
    }

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            // Id человека и номер обязательны для заполнения
            [['person_id', 'number'], 'required'],
            // Id человека должен быть целым числом
            ['person_id', 'integer'],
            // Номер должен быть строкой не более 18 символов
            ['number', 'string', 'max' => 18],
            // Номер должен соответствовать формату +7 (NNN) NN-NNN-NN
            ['number', 'match', 'pattern' => '/^\+7 \(\d{3}\) \d{2}-\d{3}-\d{2}$/'],
            // Номер должен быть уникальным
            ['number', 'unique'],
        ];
    }

    /**
     * Названия атрибутов модели
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Id человека',
            'number' => 'Номер',
        ];
    }

    /**
     * Возвращает связь с моделью Person
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
}
