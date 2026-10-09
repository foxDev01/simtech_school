<?php
/**
 * Образец конфигурации.
 *
 * Скопируйте этот файл в config.php и укажите свои данные:
 *     copy config.sample.php config.php      (Windows)
 *     cp   config.sample.php config.php      (Linux/macOS)
 *
 * Файл config.php добавлен в .gitignore и не должен попадать в репозиторий.
 */
return [
    // Параметры подключения к базе данных
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'name' => 'form_contact_us',
    ],

    // Параметры отправки почты (SMTP)
    'mail' => [
        'host'       => 'smtp.gmail.com',
        'username'   => 'your.email@gmail.com',
        'password'   => 'your-app-password', // для Gmail нужен пароль приложения
        'secure'     => 'ssl',                // 'ssl' или 'tls'
        'port'       => 465,
        'from_email' => 'your.email@gmail.com',
        'from_name'  => 'С формы сайта',
        'to_email'   => 'recipient@gmail.com',
    ],

    // Параметры загрузки файлов
    'upload' => [
        'dir'         => __DIR__ . '/upload',
        'max_size'    => 5 * 1024 * 1024, // 5 МБ
        'allowed_ext' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf', 'vsd', 'vsdx'],
    ],
];
