<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Модель Person представляет собой человека с фамилией, именем, отчеством и датой последнего редактирования
 * @property int $id идентификатор человека
 * @property string $last_name фамилия человека
 * @property string $first_name имя человека
 * @property string $middle_name отчество человека
 * @property string $updated_at дата последнего редактирования
 * @property Phone[] $phones телефоны человека
 */
class Person extends ActiveRecord
{
    /**
     * Возвращает название таблицы в базе данных
     * @return string
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * Поведения модели
     * @return array
     */
    public function behaviors()
    {
        return [
            // Поведение TimestampBehavior автоматически обновляет атрибут updated_at при изменении модели
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            // Фамилия и имя обязательны для заполнения
            [['last_name', 'first_name'], 'required'],
            // Фамилия, имя и отчество должны быть строками не более 255 символов
            [['last_name', 'first_name', 'middle_name'], 'string', 'max' => 255],
            // Отчество может быть пустым
            ['middle_name', 'default'],
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
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'updated_at' => 'Дата последнего редактирования',
        ];
    }

    /**
     * Возвращает связь с моделью Phone
     * @return \yii\db\ActiveQuery
     */
    public function getPhones()
    {
        return $this->hasMany(Phone::className(), ['person_id' => 'id']);
    }
}
