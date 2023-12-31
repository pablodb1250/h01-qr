<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

function get_email_template($email_template_subject_array, $email_template_subject, $email_template_body_array, $email_template_body) {

    $email_template_subject = str_replace(
        array_keys($email_template_subject_array),
        array_values($email_template_subject_array),
        $email_template_subject
    );

    $email_template_body = str_replace(
        array_keys($email_template_body_array),
        array_values($email_template_body_array),
        $email_template_body
    );

    return (object) [
        'subject' => $email_template_subject,
        'body' => $email_template_body
    ];
}

function send_server_mail($to, $from, $title, $content) {

    $headers = "From: " . strip_tags($from) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    /* Check if receipient is array or not */
    $to_processed = $to;

    if(is_array($to)) {
        $to_processed = '';

        foreach($to as $address) {
            $to_processed .= ',' . $address;
        }

    }

    return mail($to_processed, $title, $content, $headers);
}

function send_mail($to, $title, $content, $test = false) {

    /* Templating for the title */
    $replacers = [
        '{{WEBSITE_TITLE}}' => settings()->main->title
    ];

    $title = str_replace(
        array_keys($replacers),
        array_values($replacers),
        $title
    );

    /* Template and content preparing */
    $email_template_raw = file_get_contents(THEME_PATH . 'views/partials/email.html');

    $replacers = [
        '{{CONTENT}}'   => $content,
        '{{URL}}'       => url(),
        '{{WEBSITE_TITLE}}' => settings()->main->title,
        '{{HEADER}}'    => '<a href="' . url() . '">' . (!empty(settings()->logo) ? '<img src="' . UPLOADS_FULL_URL . 'logo/' . settings()->logo . '" class="logo" alt="' . settings()->main->title . '" />' : '<h2>' . settings()->main->title .  '</h2>') . '</a>',
        '{{FOOTER}}'    => 'Copyright © <a href="' . url() . '">' . settings()->main->title . '</a>'
    ];

    $email_template = str_replace(
        array_keys($replacers),
        array_values($replacers),
        $email_template_raw
    );


    if(!empty(settings()->smtp->host)) {

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->SMTPDebug = $test ? 2 : 0;

            if (settings()->smtp->encryption != '0') {
                $mail->SMTPSecure = settings()->smtp->encryption;
            }

            $mail->SMTPAuth = settings()->smtp->auth;
            $mail->isHTML(true);

            $mail->Host = settings()->smtp->host;
            $mail->Port = settings()->smtp->port;
            $mail->Username = settings()->smtp->username;
            $mail->Password = settings()->smtp->password;

            $mail->setFrom(settings()->smtp->from, settings()->smtp->from_name);
            $mail->addReplyTo(settings()->smtp->from, settings()->smtp->from_name);

            /* Check if receipient is array or not */
            if(is_array($to)) {
                foreach($to as $address) {
                    $mail->addAddress($address);
                }
            } else {
                $mail->addAddress($to);
            }

            $mail->Subject = $title;

            $mail->Body = $email_template;
            $mail->AltBody = strip_tags($email_template);

            /* Save errors in array for debugging */
            $errors = [];

            if($test) {
                $mail->Debugoutput = function($string, $level) use(&$errors) {
                    $errors[] = $string;
                };
            }

            $send = $mail->send();

            /* Save the errors in the returned object for output purposes */
            if($test) {
                $mail->errors = $errors;
            }

            return $test ? $mail : $send;

        } catch (Exception $e) {

            return $test ? $mail : false;

        }

    } else {
        return send_server_mail($to, settings()->smtp->from, $title, $email_template);
    }

}

