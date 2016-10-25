<?php

$config = [
    'name' => 'JNZ Group (Pty) Ltd',
    'send_to' => 'info@jnz.co.za, curtis@jnz.co.za',
    'reply_to' => 'info@jnz.co.za',
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
$email = htmlentities($_POST['email']);
$subject = htmlentities($_POST['subject']);
$msg = htmlentities($_POST['message']);

require('controllers/MailController.php');

$mail = new Mail($config);

if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    throw new Exception('Not a valid email address.');

    // echo json_encode([
    //     'sendstatus' => 0,
    //     'message' => 'Not a valid email address.'
    // ]);

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
            <td><strong>Email</strong></td>
            <td>'.$email.'</td>
        </tr>
        <tr>
            <td><strong>Subject</strong></td>
            <td>'.$subject.'</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Message</strong></td>
        </tr>
        <tr>
            <td colspan="2">'.nl2br($msg).'</td>
        </tr>
    </table>
';

$body = $mail->create('You have been contacted', 'contact-form.gif', $msg_contact);

$from['name'] = $name;
$from['email'] = $email;

// $mail->send($from, $config['send_to'], $msg_contact['title'], $body);

// Reply to sender
$msg_reply['title'] = 'Message received';
$msg_reply['body'] = '<b>Thank you for you enquiry, we will get back to you as soon as possible.</b>';

$body = $mail->create('Thank You', 'thank-you.gif', $msg_reply);

$from['name'] = $config['name'];
$from['email'] = isset($config['reply_to']) && !empty($config['reply_to']) ? $config['reply_to'] : $config['send_to'];

// $mail->send($from, $email, 'Thank you', $body);

echo json_encode([
    'sendstatus' => 1,
    'message' => 'Thank you for you enquiry, we will get back to you as soon as possible.'
]);

//$mail->redirect('../index.html');


/* End of file mailto.php */
/* Location ./mail/mailto.php */
