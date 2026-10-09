# Форма обратной связи

Приложение сохраняет заявки из формы в базу данных MySQL и отправляет их на почту
через библиотеку PHPMailer.

## Запуск на Windows (XAMPP)

Для запуска необходимы web-сервер и сервер MySQL. Проще всего установить
[XAMPP](https://www.apachefriends.org/).

0. Устанавливаем XAMPP.
1. Открываем xampp-control и запускаем **Apache** и **MySQL**.
2. Перемещаем папку с проектом на localhost.

   По умолчанию директория для localhost — `C:\xampp\htdocs\`, именно туда нужно
   скинуть папку `form_contact_us`. После перемещения получится:
   `C:\xampp\htdocs\form_contact_us`.

3. Настраиваем конфигурацию. В папке проекта копируем `config.sample.php` в
   `config.php` и указываем свои данные (подключение к БД и параметры SMTP):

   ```
   copy config.sample.php config.php
   ```

   > `config.php` добавлен в `.gitignore` и не попадает в репозиторий.

4. Импортируем базу данных. Открываем xampp-control, в пункте MySQL нажимаем
   **Admin** — откроется phpMyAdmin (при необходимости вводим логин и пароль).
   Переходим на вкладку **Импорт** и выбираем файл `db/feedback.sql` из папки
   проекта. Он создаст базу `form_contact_us` и таблицу `feedback`.

5. Открываем в браузере:
   - `http://localhost/form_contact_us/form.php` — форма;
   - `http://localhost/form_contact_us/table.php` — таблица с результатами.

## Запуск на Ubuntu (LAMPP)

1. Настраиваем окружение.
2. Перемещаем папку с проектом на localhost. По умолчанию директория —
   `/opt/lampp/htdocs/`, туда нужно скинуть папку `form_contact_us`.
   Получится: `/opt/lampp/htdocs/form_contact_us`.
3. Копируем `config.sample.php` в `config.php` и заполняем свои данные.
4. Заходим в phpMyAdmin `http://localhost/phpmyadmin/` (при необходимости вводим
   логин и пароль). Импортируем файл `db/feedback.sql`.
5. Открываем в браузере:
   - `http://localhost/form_contact_us/form.php` — форма;
   - `http://localhost/form_contact_us/table.php` — таблица с результатами.

### Если возникли проблемы с доступом

Слэш должен стоять после htdocs, команды выполняются через `sudo`:

1. `sudo chmod -R 777 /opt/lampp/htdocs/`
2. Если не получается — переходим в `/opt/lampp/`: `cd /opt/lampp/`
3. Убеждаемся, что есть папка htdocs: `ls`
4. Затем: `sudo chmod 777 htdocs/`

## Настройка отправки почты

Все параметры почты (SMTP-сервер, логин, пароль, отправитель, получатель) задаются
в файле `config.php`, созданном из `config.sample.php`. Пароли в коде не хранятся.

> Для Gmail необходимо включить двухфакторную аутентификацию и использовать
> «пароль приложения» вместо обычного пароля.
