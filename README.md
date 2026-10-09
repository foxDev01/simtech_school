# simtech_school

Проект «Форма обратной связи» (`form_contact_us`): PHP-форма, которая сохраняет
заявки в MySQL и отправляет их на почту через PHPMailer.

Подробная инструкция — в [`form_contact_us/README.md`](form_contact_us/README.md).

## Кратко: запуск на Windows (XAMPP)

Для запуска необходимы web-сервер и сервер MySQL. Удобнее всего использовать
[XAMPP](https://www.apachefriends.org/).

0. Устанавливаем XAMPP.
1. Открываем xampp-control и запускаем **Apache** и **MySQL**.
2. Перемещаем папку проекта `form_contact_us` в `C:\xampp\htdocs\`.
3. Копируем `form_contact_us/config.sample.php` в `form_contact_us/config.php`
   и заполняем свои данные (БД и SMTP). Файл `config.php` в репозиторий не попадает.
4. Открываем phpMyAdmin (xampp-control → MySQL → **Admin**), вкладка **Импорт**,
   выбираем `form_contact_us/db/feedback.sql`.
5. В браузере:
   - `http://localhost/form_contact_us/form.php` — форма;
   - `http://localhost/form_contact_us/table.php` — таблица с результатами.

## Кратко: запуск на Ubuntu (LAMPP)

1. Настраиваем окружение.
2. Перемещаем папку `form_contact_us` в `/opt/lampp/htdocs/`.
3. Копируем `config.sample.php` в `config.php` и заполняем данные.
4. Заходим в phpMyAdmin `http://localhost/phpmyadmin/` и импортируем
   `db/feedback.sql`.
5. В браузере:
   - `http://localhost/form_contact_us/form.php` — форма;
   - `http://localhost/form_contact_us/table.php` — таблица с результатами.

### Если возникли проблемы с доступом

Слэш должен стоять после htdocs, команды выполняются через `sudo`:

1. `sudo chmod -R 777 /opt/lampp/htdocs/`
2. Если не получается — переходим в `/opt/lampp/`: `cd /opt/lampp/`
3. Убеждаемся, что есть папка htdocs: `ls`
4. Затем: `sudo chmod 777 htdocs/`

## Настройка почты

Параметры SMTP задаются в `config.php` (создаётся из `config.sample.php`).
Пароли в исходном коде не хранятся.
