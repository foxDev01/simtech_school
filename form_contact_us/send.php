<?php
header("Location:form.php");
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
require 'connect.php';
//файл вносится на сервер
$file = "upload/".$_FILES['file']['name'];
 move_uploaded_file($_FILES['file']['tmp_name'], $file);
  //if(isset($_FILES['file']['name']))
//{
// echo "Загруженный файл: ".$_FILES['file']['name']."</br>";
// echo "Размер: ".$_FILES['file']['size']."байт";
//}
//   $path = scandir("upload");
//   foreach($path as $f){
//     if ($f !='.' and $f !='..'){
//       echo $f. "<br>";
//     }
//} $hed
// Переменные, которые отправляет пользователь
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$phone=$_POST['tel'];
$times=$_POST['time'];
$occasion=$_POST['occasion'];
$file=$_FILES['file']['name'];
$msg=$_POST['msg'];
$alert= "<script> alert('Ваша заявка отпарвлена');</script>";

$title = $occasion;
$body = "
<h2>Новое письмо</h2>
<b>Имя:</b> $fname<br>
<b>Фамилия:</b>$lname<br>
<b>Телефон:</b>$phone<br>
<b>Время:</b>$times<br>
<b>Повод:</b>$occasion<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>$msg";

//отправка данных в базу даных
$sql = "INSERT INTO feedback (fname,  lname, email,  tel,  tim,  occasion, files,  msg)
              VALUES ('$fname','$lname','$email','$phone','$times','$occasion','$file','$msg')";

if ($conn->query($sql) === TRUE) {
  
}

 else{
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    // $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'my.web.test073@gmail.com'; // Логин на почте
    $mail->Password   = 'chuvash_web'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('faraday073@gmail.com', 'C формы сайта'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('faraday073@gmail.com');  
    

    // Прикрипление файлов к письму

if (!empty($_FILES['file']['tmp_name'])) {
    $filePath="upload/" . $_FILES['file']['name'];
        if (copy($filePath, $_FILES['file']['tmp_name'])){
            $fileAtach=$filePath;
            $mail->addAttachment($fileAtach);
        }
      
}

// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";
  echo $alert;

} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $statuses = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

echo json_encode(["result" => $result, "resultfile" => $file, "status" => $statuses]);


?>