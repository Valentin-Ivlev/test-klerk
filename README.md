### Тестовое задание на позицию «Backend-разработчик»
Вам предлагается выполнить два задания. По обеим задачам необходимо описать затраченное время (с учётом времени на поиск информации, чтение документации и т.п.). Кроме того, приветствуются любые текстовые комментарии и заметки к задачам.
## Задача 1
Your goal is to make that 6 qu kata from codewars. You should write function balance using all you know about PHP 8.1 best practices and PSRs. Result should be published on github.

Description: Each exclamation mark weight is 2; Each question mark weight is 3. Put two string left and right to the balance, Are they balanced?
If the left side is more heavy, return "Left"; If the right side is more heavy, return "Right"; If they are balanced, return "Balance".

Examples:
<pre>
balance("!!","??") === "Right"
balance("!??","?!!") === "Left"
balance("!?!!","?!?") === "Left"
balance("!!???!????","??!!?!!!!!!!") === "Balance"
</pre>
## Задача 2
Описание предметной области - делаем простой телефонный справочник на Yii2, база данных должна состоять из 2х таблиц: Люди и телефоны. У каждого человека может быть от 0 до бесконечности телефонных номеров. Каждый номер может быть только у одного человека.
Карточка человека состоит из: фамилии, имени, отчества, даты последнего редактирования и телефонов (от 0 до бесконечности). Телефоны должны валидироваться, формат +7 (NNN) NN-NNN-NN

Требуется спроектировать продукт, реализовать его на yii2, предоставить:
1.	SQL код создания базы со связями между таблицами, если есть и добавлением демо данных - несколько пользователей с несколькими телефонами.
2.	Код модели (моделей) с валидацией, учесть момент, что при удалении человека, должны удаляться все его телефоны, а при обновлении - автоматически меняться дата последнего обновления
3.	Код контроллера, который обеспечивает REST API для работы с таким справочником, для простоты, без проверки прав. При редактировнии, добавлении, просмотре человека, в это же АПИ должны передаваться и телефонные номера, то есть отдельного АПИ где происходит работа только с номерами быть не должно.
Код можно разместить на github. Нет необходимости предоставлять рабочий проект, достаточно трёх файлов: модель, контроллер и SQL. Запускать код не будем - только смотреть на него. 