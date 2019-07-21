# Переопределение кастомной отправки почты через SMTP

Устанавливаем пакет PHPMailer для работы с SMTP:

```
composer require phpmailer/phpmailer
```

Добавляем код, который переопределит стандартный `custom_mail` на следующий:

```php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Отпраляем почту через SMTP-сервер
 *
 * @see CEvent::HandleEvent()
 * @see bxmail()
 *
 * @param string $sTo Адрес получателя
 * @param string $sSubject Тема
 * @param string $sMessage Текст сообщения
 * @param string $sAdditionalHeaders Дополнительные заголовки передаются Битриксом почти всегда ('FROM' передаётся здесь)
 *
 * @return bool
 * @throws Exception
 */
function custom_mail($sTo, $sSubject, $sMessage, $sAdditionalHeaders = '')
{
    $oMail = new PHPMailer;

    $oMail->SMTPDebug = 0; // логирование ошибок (0 - не выводить, 2 - выводить)
    $oMail->CharSet = 'UTF-8';
    $oMail->isSMTP();
    $oMail->SMTPAuth = true;

    $oMail->Host = ''; // пример: smtp.yandex.ru
    $oMail->Username = ''; // пример: noreplyb@mail.com
    $oMail->Password = ''; // пример: login
    $oMail->SMTPSecure = ''; // пример: ssl
    $oMail->Port = 0; // пример: 465

    $sDMessage = '';

    preg_match('/From: (.+)\n/i', $sAdditionalHeaders, $matches);
    list(, $sFrom) = $matches;

    $sDMessage .= '$from - ' . $sFrom . ' +++ ';
    $sDMessage .= '$to - ' . $sTo . ' +++ ';
    $sDMessage .= '$subject - ' . $sSubject . ' +++ ';
    $sDMessage .= '$message - ' . $sMessage . ' +++ ';

    $oMail->setFrom($sFrom, '');
    $oMail->addAddress($sTo, '');
    $oMail->addReplyTo($sFrom, '');
    $oMail->addCC('mail2@mail.ru');
    $oMail->AddBCC('mail3@xmail.ru');

    $oMail->Subject = $sSubject;
    $oMail->Body = $sMessage;

    if (!$oMail->send()) {
        file_put_contents(__DIR__ . '/emaillog.txt', 'Mailer Error: ' . $sDMessage . ' ' . $oMail->ErrorInfo);

        return false;
    }

    return true;
}
```