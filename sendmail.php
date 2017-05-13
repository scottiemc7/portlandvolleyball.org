<?php
require_once 'lib/swiftmailer/lib/swift_required.php';

$transport = Swift_SmtpTransport::newInstance('sub5.mail.dreamhost.com', 465, "ssl")
  ->setUsername('test@portlandvolleyball.org')
  ->setPassword('blahblah');

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance('Test Subject')
  ->setFrom(array('test@portlandvolleyball.org' => 'Josh Bremer'))
  ->setTo(array('joshua.bremer@gmail.com'))
  ->setBody('This is a test mail.');

$result = $mailer->send($message);
