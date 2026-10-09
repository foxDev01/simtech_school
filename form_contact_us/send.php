<?php
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

header('Content-Type: application/json; charset=utf-8');

$config = require __DIR__ . '/config.php';
require __DIR__ . '/connect.php';

/**
 * Отправляет JSON-ответ и завершает работу скрипта.
 */
function respond($result, array $extra = [])
{
    echo json_encode(array_merge(['result' => $result], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

// Принимаем только POST-запросы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', ['status' => 'Метод не поддерживается']);
}

// --- Загрузка файла ---
$uploadedFile = ''; // имя сохранённого файла (для БД)
$uploadPath   = ''; // полный путь к сохранённому файлу

if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        respond('error', ['status' => 'Ошибка загрузки файла (код ' . $_FILES['file']['error'] . ')']);
    }

    if ($_FILES['file']['size'] > $config['upload']['max_size']) {
        respond('error', ['status' => 'Файл слишком большой']);
    }

    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $config['upload']['allowed_ext'], true)) {
        respond('error', ['status' => 'Недопустимый тип файла']);
    }

    // Генерируем безопасное уникальное имя файла (не используем имя от пользователя).
    $safeName   = bin2hex(random_bytes(16)) . ($ext !== '' ? '.' . $ext : '');
    $uploadPath = rtrim($config['upload']['dir'], '/\\') . DIRECTORY_SEPARATOR . $safeName;

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
        respond('error', ['status' => 'Не удалось сохранить файл']);
    }

    $uploadedFile = $safeName;
}

// --- Поля формы ---
$fname    = trim($_POST['fname'] ?? '');
$lname    = trim($_POST['lname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['tel'] ?? '');
$times    = trim($_POST['time'] ?? '');
$occasion = trim($_POST['occasion'] ?? '');
$msg      = trim($_POST['msg'] ?? '');

if ($fname === '' || $email === '' || $phone === '') {
    respond('error', ['status' => 'Заполните обязательные поля']);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond('error', ['status' => 'Некорректный email']);
}

// --- Сохранение в базу данных (prepared statement) ---
$sql  = "INSERT INTO feedback (fname, lname, email, tel, tim, occasion, files, msg)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    respond('error', ['status' => 'Ошибка подготовки запроса к базе данных']);
}

$stmt->bind_param('ssssssss', $fname, $lname, $email, $phone, $times, $occasion, $uploadedFile, $msg);

if (!$stmt->execute()) {
    $stmt->close();
    respond('error', ['status' => 'Ошибка записи в базу данных']);
}
$stmt->close();

// --- Отправка письма ---
$title = $occasion !== '' ? 'Новая заявка: ' . $occasion : 'Новая заявка с сайта';
$body  = "
<h2>Новое письмо</h2>
<b>Имя:</b> " . htmlspecialchars($fname, ENT_QUOTES, 'UTF-8') . "<br>
<b>Фамилия:</b> " . htmlspecialchars($lname, ENT_QUOTES, 'UTF-8') . "<br>
<b>Телефон:</b> " . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . "<br>
<b>Время:</b> " . htmlspecialchars($times, ENT_QUOTES, 'UTF-8') . "<br>
<b>Повод:</b> " . htmlspecialchars($occasion, ENT_QUOTES, 'UTF-8') . "<br>
<b>Почта:</b> " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "<br><br>
<b>Сообщение:</b><br>" . nl2br(htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'));

$mail   = new PHPMailer\PHPMailer\PHPMailer(true);
$status = '';

try {
    $mail->isSMTP();
    $mail->CharSet    = 'UTF-8';
    $mail->SMTPAuth   = true;
    $mail->Host       = $config['mail']['host'];
    $mail->Username   = $config['mail']['username'];
    $mail->Password   = $config['mail']['password'];
    $mail->SMTPSecure = $config['mail']['secure'];
    $mail->Port       = $config['mail']['port'];
    $mail->setFrom($config['mail']['from_email'], $config['mail']['from_name']);

    // Получатель письма
    $mail->addAddress($config['mail']['to_email']);

    // Прикрепление файла к письму
    if ($uploadPath !== '' && is_file($uploadPath)) {
        $mail->addAttachment($uploadPath);
    }

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body    = $body;
    $mail->send();

    $result = 'success';
} catch (Exception $e) {
    $result = 'error';
    $status = 'Сообщение не было отправлено. Причина ошибки: ' . $mail->ErrorInfo;
}

respond($result, ['status' => $status, 'resultfile' => $uploadedFile]);
