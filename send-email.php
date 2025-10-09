<?php
//Московский  часовой пояс
date_default_timezone_set('Europe/Moscow');

// Включаем вывод ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Подключаем PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные формы
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $note = trim($_POST["note"]);
    
    // Создаем объект PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Настройки SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'mas@eternis.ru';
        $mail->Password = 'zznrjcyliebzawlc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        
        // От кого
        $mail->setFrom('mas@eternis.ru', 'Заявка с сайта zashitapoj.ru');
        
        // Кому
        $mail->addAddress('mas@eternis.ru');
        
        // Тема и тело письма
        $mail->Subject = 'Новая заявка с сайта zashitapoj.ru';
        $mail->Body    = "Поступила новая заявка с сайта zashitapoj.ru:\n\nИмя: $name\nТелефон: $phone\nПримечание: $note\n\nДата: " . date('d.m.Y H:i:s');
        
        // Отправляем
        $mail->send();
        
        // Возвращаем успех и закрываем окно
        echo '<script>
            window.history.back(); // Возврат на предыдущую страницу
            alert("Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.");
        </script>';
        
    } catch (Exception $e) {
        // Возвращаем ошибку
        echo '<script>
            window.history.back();
            alert("Ошибка при отправке заявки. Пожалуйста, попробуйте позже.");
        </script>';
    }
    
    exit; // Завершаем выполнение
}
?>