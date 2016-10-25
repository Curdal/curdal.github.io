<?php

$config = [
    'name' => 'Cyber Finance',
   /* 'send_to' => 'info@cyberfinance.co.za',*/
   'send_to' => 'darryl.october@gmail.com',
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

$name = htmlentities($_POST['name']);
$surname = htmlentities($_POST['surname']);
$contact_number = htmlentities($_POST['contact_number']);
$email = htmlentities($_POST['email']);
$msg = htmlentities($_POST['message']);

require('controllers/MailController.php');

$mail = new Mail($config);

if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    throw new Exception('Not a valid email address.');
    exit;
}

$msg_contact['title'] = 'Contact Form';
$msg_contact['body'] = '
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
            <td><strong>Message</strong></td>
            <td>'.nl2br($msg).'</td>
        </tr>
    </table>
';

$body = $mail->create('New Website Contact', $msg_contact);

$from['name'] = "{$name} {$surname}";
$from['email'] = $email;

$mail->send($from, $config['send_to'], $msg_contact['title'], $body);

// Reply to sender
$msg_reply['title'] = 'Message received';
$msg_reply['body'] = '<b>Thank you for you enquiry, we will get back to you as soon as possible.</b>';

$body = $mail->create('Thank You', $msg_reply);

$from['name'] = $config['name'];
$from['email'] = isset($config['reply_to']) && !empty($config['reply_to']) ? $config['reply_to'] : $config['send_to'];

$mail->send($from, $email, 'Thank you', $body);

$mail->redirect('../thank-you');

/* End of file mailto.php */
/* Location ./mail/mailto.php */
