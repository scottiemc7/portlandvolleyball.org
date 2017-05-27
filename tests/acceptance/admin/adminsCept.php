<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('create a new admin');
$I->lookForwardTo('be able to log in as the new admin');
$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');
$I->see('PVA Administration');
$I->click('Admins');

$I->seeNumberOfElements('.admins-table__row', 1);

$I->fillField('uname', 'newuser');
$I->fillField('password', 'Password1$');
$I->click('submit');

$I->seeNumberOfElements('.admins-table__row', 2);

$I->click('Logout');

$I->fillField('uname', 'newuser');
$I->fillField('pw', 'Password1$');
$I->click('submit');
$I->see('PVA Administration');