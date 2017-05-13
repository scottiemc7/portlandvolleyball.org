<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'lib/swiftmailer/lib/swift_required.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/email.php';

class Emailer {
  var $name;
  function send_email($to, $subject, $body) {
    $transport = Swift_SmtpTransport::newInstance('sub5.mail.dreamhost.com', 465, "ssl")
      ->setUsername('test@portlandvolleyball.org')
      ->setPassword('blahblah');

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance($subject)
      ->setFrom(array('test@portlandvolleyball.org' => 'Portland Volleyball'))
      ->setTo(array($to))
      ->setBody($body);

    $result = $mailer->send($message);
  }
}




