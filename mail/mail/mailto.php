<?php

$config = [
    'name' => 'Cyber Finance',
 /*    'send_to' => 'info@cyberfinance.co.za',*/
   'send_to' => 'info@cyberfinance.co.za, neilflying@rocketmail.com',
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
$income = htmlentities($_POST['income']);
$review = htmlentities($_POST['review']);
$hear_about = htmlentities($_POST['hear_about']);
$expenses = isset($_POST['expenses']) ? htmlentities($_POST['expenses']) : null;
$contact_time = htmlentities($_POST['best_contact_time']);
$language = htmlentities($_POST['language']);

/* Sending data to the system under seo leads */
// $postUrl = 'http://41.164.157.42/callcenter/seo_leads?' .
//            'name=' . urlencode($name) . '&' .
//            'surname=' . urlencode($surname) . '&' .
//            'contact_number=' . urlencode($contact_number) . '&' .
//            'email=' . urlencode($email) . '&' .
//            'income_after_deductions=' . urlencode($income) . '&' .
// 		   'review=' . urlencode($review) . '&' .
// 		   'hear_about=' . urlencode($hear_about) . '&' .
//            'monthly_living_expenses=' . urlencode($expenses) . '&'.
//            'monthly_debt_obligations=&' .
//            'best_contact_time=' . urlencode($contact_time) . '&' .
//            'been_debt_review=&'.
//            'heard_about_us=';
//
// $ch = curl_init();
//
// curl_setopt($ch, CURLOPT_URL, $postUrl);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('application/x-www-form-urlencoded'));
//
// $response = curl_exec($ch);
//
// curl_close($ch);

require('controllers/MailController.php');

$mail = new Mail($config);

if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    throw new Exception('Not a valid email address.');
    exit;
}

$msg_contact['title'] = 'Free Consultation';
$msg_contact['body'] = '
    <table>
        <tr>
            <td width="30%"><strong>Name</strong></td>
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
            <td><strong>Have been under debt review before</strong></td>
            <td>'.$review.'</td>
        </tr>
        <tr>
            <td><strong>Hear About</strong></td>
            <td>'.$hear_about.'</td>
        </tr>'.
        //<tr>
            //<td><strong>Expenses</strong></td>
            //<td>'.$expenses.'</td>
        //</tr>
        '<tr>
            <td><strong>Best Contact Time</strong></td>
            <td>'.$contact_time.'</td>
        </tr>
        </table>
';

$body = $mail->create('New Consultation Request', $msg_contact);

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
