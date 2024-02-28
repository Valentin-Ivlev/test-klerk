<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use app\models\Person;
use app\models\Phone;

/**
 * Контроллер PhonebookController обеспечивает REST API для работы с телефонным справочником
 */
class PhonebookController extends ActiveController
{
    // Моделью по умолчанию
    public $modelClass = 'app\models\Person';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    // Создание человека с телефонами
    public function actionCreate()
    {
        $person = new Person();

        // Загружаем данные из запроса в модель Person
        $person->load(Yii::$app->request->post(), '');

        // Проверяем валидность модели Person
        if ($person->validate()) {

            if ($person->save()) {

                $phones = Yii::$app->request->post('phones', []);

                // Перебираем телефоны
                foreach ($phones as $phone) {

                    $phoneModel = new Phone();

                    $phoneModel->load($phone, '');

                    $phoneModel->person_id = $person->id;

                    // Проверяем валидность модели Phone
                    if ($phoneModel->validate()) {

                        if (!$phoneModel->save()) {
                            // Если сохранение не удалось, то исключение
                            throw new ServerErrorHttpException('Failed to save phone.');
                        }
                    } else {
                        // Если валидация не прошла, то исключение с ошибками
                        throw new ServerErrorHttpException('Phone validation failed: ' . json_encode($phoneModel->errors));
                    }
                }

                // Возвращаем модель Person с телефонами в формате JSON
                return $person->toArray([], ['phones']);
            } else {
                // Если сохранение не удалось, то исключение
                throw new ServerErrorHttpException('Failed to save person.');
            }
        } else {
            // Если валидация не прошла, то исключение с ошибками
            throw new ServerErrorHttpException('Person validation failed: ' . json_encode($person->errors));
        }
    }

    // Обновление человека с телефонами
    public function actionUpdate($id)
    {
        // Находим запись Person по идентификатору
        $person = Person::findOne($id);

        // Проверяем, что запись Person существует
        if ($person) {

            $person->load(Yii::$app->request->post(), '');

            // Проверяем валидность модели Person
            if ($person->validate()) {

                if ($person->save()) {

                    $phones = Yii::$app->request->post('phones', []);

                    // Удаляем все старые телефоны, связанные с моделью Person
                    Phone::deleteAll(['person_id' => $person->id]);

                    // Перебираем телефоны
                    foreach ($phones as $phone) {

                        $phoneModel = new Phone();

                        $phoneModel->load($phone, '');

                        $phoneModel->person_id = $person->id;

                        // Проверяем валидность модели Phone
                        if ($phoneModel->validate()) {

                            if (!$phoneModel->save()) {
                                // Если сохранение не удалось, то исключение
                                throw new ServerErrorHttpException('Failed to save phone.');
                            }
                        } else {
                            // Если валидация не прошла, то исключение с ошибками
                            throw new ServerErrorHttpException('Phone validation failed: ' . json_encode($phoneModel->errors));
                        }
                    }

                    // Возвращаем модель Person с телефонами в формате JSON
                    return $person->toArray([], ['phones']);
                } else {
                    // Если сохранение не удалось, то исключение
                    throw new ServerErrorHttpException('Failed to save person.');
                }
            } else {
                // Если валидация не прошла, то исключение с ошибками
                throw new ServerErrorHttpException('Person validation failed: ' . json_encode($person->errors));
            }
        } else {
            // Если человек не найден, то исключение
            throw new NotFoundHttpException("Person not found.");
        }
    }

    // Удаления человека с телефонами
    public function actionDelete($id)
    {
        // Находим запись Person по идентификатору
        $person = Person::findOne($id);

        // Проверяем, что запись Person существует
        if ($person) {
            // Удаляем запись Person из базы данных
            if ($person->delete()) {
                // Возвращаем статус 204 (No Content)
                Yii::$app->response->statusCode = 204;
            } else {
                // Если удаление не удалось, то исключение
                throw new ServerErrorHttpException('Failed to delete person.');
            }
        } else {
            // Если человек не найден, то исключение
            throw new NotFoundHttpException("Person not found.");
        }
    }
}
