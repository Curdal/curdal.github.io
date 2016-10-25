<?php

class Mail
{
    protected $config;

    public function __construct(array $config)
    {
        /**
         * -------------------------------------------------------------------
         * COMPANY SETTINGS
         * -------------------------------------------------------------------
         * This file will contain the settings needed to complete your company.
         *
         * -------------------------------------------------------------------
         * EXPLANATION OF VARIABLES
         * -------------------------------------------------------------------
         *
         *    ['name']     The name of the company
         *    ['social']     The array of social links and icon,
         *                supports:
         *                        facebook, twitter, linkedIn, google-plus
         *                useage:
         *                        $config['social']['twitter']['url'] = '';
         *                        $config['social']['twitter']['icon'] = '';
         *
         *    ['img_dir'] The URL to the directory used to find images needed
         *                for the emails include a forward slash at the end
         *                of the URL
         *
         */

        $this->config = $config;

        $this->config['img_dir'] = 'http://' . $_SERVER['SERVER_NAME'] . '/img/email/';
    }

    /**
     * -------------------------------------------------------------------
     * Email Function
     * -------------------------------------------------------------------
     * This function will construct the email to the user as defined.
     *
     * -------------------------------------------------------------------
     * EXPLANATION OF VARIABLES
     * -------------------------------------------------------------------
     *
     *    $title - The HTML title
     *    $image - The image needed for the heading
     *    $message['title'] - The message title
     *    $message['body'] - The contents of the message
     *
     */
    public function create($title, $image, $message)
    {
        $links = '';

        if (isset($this->config['social']) || !empty($this->config['social'])) {
            foreach ($this->config['social'] as $key => $value) {
                $links .= '<td style="font-family: Roboto, sans-serif; font-size: 12px; font-weight: bold;">
                    <a href="' . $value['url'] . '" style="color: #ffffff;">
                        <img src="' . $this->config['img_dir'] . $value['icon'] . '" alt="' . $key . '" width="38" height="38" style="display: block;" border="0"/>
                    </a>
                </td>
                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>';
            }
        }

        $temp = '
            <!Doctype html>
            <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    <title>' . $this->config['name'] . ' :: ' . $title . '</title>

                    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,600,700">
                </head>
                <body bgcolor="#f9f9f9">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 0 0 30px 0;">

                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-radius: 5px; overflow: hidden;">
                                    <tr>
                                        <td align="center" bgcolor="#000000" style="padding: 40px 0 30px 0; color: #ffffff; font-size: 28px; font-weight: bold; font-family: Roboto, sans-serif;">
                                            <img src="' . $this->config['img_dir'] . $image . '" alt="Company Logo and Message Heading" width="300" height="230" style="display: block;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td style="color: #151515; font-family: Roboto, sans-serif; font-size: 24px;">
                                                        <b>' . $message['title'] . '</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px 0 30px 0; color: #151515; font-family: Roboto, sans-serif; font-size: 16px; line-height: 20px;">' . $message['body'] . '</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td style="color: #ffffff; font-family: Roboto, sans-serif; font-size: 14px;" width="75%">
                                                        &copy; ' . $this->config['name'] . ' ' . date('Y') . '
                                                    </td>
                                                    <td align="right" width="25%">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>' . $links . '</tr>
                                                        </table>
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

        return $temp;
    }

    /**
     * -------------------------------------------------------------------
     * Send Mail Function
     * -------------------------------------------------------------------
     * This will send an email to the user as defined.
     *
     * -------------------------------------------------------------------
     * EXPLANATION OF VARIABLES
     * -------------------------------------------------------------------
     *
     *    $from['name'] - The hostname of your database server.
     *    $from['email'] - The hostname of your database server.
     *    $receiver - The receiver email address
     *    $subject - The message subject
     *    $email_body - The body of the email
     *
     */
    public function send($from, $receiver, $subject, $email_body)
    {
        $header  = "From: " . $from['name'] . "<" . $from['email'] . ">\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        mail($receiver, $subject, $email_body, $header);
    }
}

/* End of file Mail.php */
/* Location ./mail/contollers/Mail.php */
