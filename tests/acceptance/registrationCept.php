<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('register for a league');
$I->lookForwardTo('and see the info in the database');
$I->amOnPage('/register.php');
$I->fillField('teamName','Team Name');
$I->fillField('mgrName','Joe Blow');
$I->fillField('addr1','123 Pine st.');
$I->fillField('addr2','Apt 321');
$I->fillField('city','Portland');
$I->fillField('state','OR');
$I->fillField('zip','92713');
$I->fillField('email','joe.blow@example.com');
$I->fillField('email2','joey.blower@example.com');
$I->fillField('phone1','555-555-5555');
$I->fillField('phone2','666-666-6666');
$I->fillField('alt_name','Joey Blower');
$I->fillField('alt_phone1','123-456-7890');
$I->fillField('alt_phone2','098-765-4321');
$I->fillField('alt_email','jane.blow@example.com');
$I->selectOption('league', '25'); // Coed A Thursday Doubleheaders - Thursday
$I->selectOption('league2', '120'); // Coed A Wednesday - Wednesday
$I->selectOption('newOld', 'Returning team');
$I->fillField('comments', 'I like this league');
$I->click('Register your team');
$I->see('Wait!  You\'re not done yet!');
$I->see('Your registration will not be complete until we\'ve also received your payment for this season.');


// Now let's make sure the administrator can see the results
$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');
$I->click('Registrations');
$I->click('Team Name');

$I->see('Team Name');
$I->see('Joe Blow');
$I->see('555-555-5555');
$I->see('666-666-6666');
$I->see('joe.blow@example.com');
$I->see('joey.blower@example.com');
$I->see('Joey Blower');
$I->see('jane.blow@example.com');
$I->see('Coed A Thursday Doubleheaders - Thursday');
$I->see('Coed A Wednesday - Wednesday');
$I->see('123 Pine st.');
$I->see('Apt 321');
$I->see('Portland');
$I->see('OR');
$I->see('92713');
$I->see('I like this league');
$I->see('Returning team');


