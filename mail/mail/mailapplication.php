<?php

require('PHPMailer/PHPMailerAutoload.php');

$config = [
    'name' => 'Cyber Finance',
    'send_to' => 'info@cyberfinance.co.za',
    'reply_to' => 'info@cyberfinance.co.za',
    // 'social' => [
    //     'twitter' => [
    //         'url' => '',
    //         'icon' => ''
    //     ],
    //     'facebook' => [
    //         'url' => '',
    //         'icon' => ''
    //     ],
    // ],
];

$title = htmlentities($_POST['title']);
$name = htmlentities($_POST['name']);
$surname = htmlentities($_POST['surname']);
$contact_number = htmlentities($_POST['contact_number']);
$email = htmlentities($_POST['email']);
$msg = htmlentities($_POST['desc']);
$attached = $_FILES['resume'];

require('controllers/MailController.php');

$reply_mail = new Mail($config);
$mail = new PHPMailer();

if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    throw new Exception('Not a valid email address.');
    exit;
}

$mail->FromName = $config['name'];
$mail->From = $config['reply_to'];
$mail->addAddress($config['send_to'], $config['name']); 
$mail->addAttachment($attached['tmp_name'], $attached['name']);
$mail->isHTML(true);
$mail->Subject = "New {$title} :: Application";
$mail->Body = '
    <!Doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title>' . $config['name'] . ' :: New ' . $title . ' Application</title>
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,600,700">
        </head>
        <body bgcolor="#f9f9f9">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 0 30px 0;">

                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-radius: 5px; overflow: hidden;">
                            <tr>
                                <td align="center" bgcolor="#000000" style="padding: 40px 0 30px 0; color: #ffffff; font-size: 28px; font-weight: bold; font-family: Roboto, sans-serif;">New ' . $title . ' Application</td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="color: #151515; font-family: Roboto, sans-serif; font-size: 24px;">
                                                <b>New ' . $title . ' Application</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 20px 0 30px 0; color: #151515; font-family: Roboto, sans-serif; font-size: 16px; line-height: 20px;">
                                                <table>
                                                    <tr>
                                                        <td><strong>Name</strong></td>
                                                        <td>'.$name.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Surname</strong></td>
                                                        <td>'.$surname.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Contact Number</strong></td>
                                                        <td>'.$contact_number.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email</strong></td>
                                                        <td>'.$email.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>About Applicant</strong></td>
                                                        <td>'.nl2br($msg).'</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="color: #ffffff; font-family: Roboto, sans-serif; font-size: 14px;">
                                                &copy; ' . $config['name'] . ' ' . date('Y') . '
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    </html>
';

if (! $mail->send()) {
    echo 'Message could not be sent. If you see this please contact us as <a href="mailto:'.$config['send_to'].'">'.$config['send_to'].'</a><br><br>';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

// Reply to sender
$msg_reply['title'] = 'Message received';
$msg_reply['body'] = '<b>Thank you for you enquiry, we will get back to you as soon as possible.</b>';

$body = $reply_mail->create('Thank You', $msg_reply);

$from['name'] = $config['name'];
$from['email'] = isset($config['reply_to']) && !empty($config['reply_to']) ? $config['reply_to'] : $config['send_to'];

$reply_mail->send($from, $email, 'Thank you', $body);

$reply_mail->redirect('../thank-you-career');
