# Overriding custom mail sending via SMTP

Install the PHPMailer package to work with SMTP:

```bash
composer require phpmailer/phpmailer
```

Add code that will override the standard `custom_mail` to the following:

```php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * @see CEvent::HandleEvent()
 * @see bxmail()
 *
 * @param string $sTo
 * @param string $sSubject
 * @param string $sMessage
 * @param string $sAdditionalHeaders
 *
 * @return bool
 * @throws Exception
 */
function custom_mail($sTo, $sSubject, $sMessage, $sAdditionalHeaders = '')
{
    $oMail = new PHPMailer;

    $oMail->SMTPDebug = 0;
    $oMail->CharSet = 'UTF-8';
    $oMail->isSMTP();
    $oMail->SMTPAuth = true;

    $oMail->Host = '';
    $oMail->Username = '';
    $oMail->Password = '';
    $oMail->SMTPSecure = '';
    $oMail->Port = 0;

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
