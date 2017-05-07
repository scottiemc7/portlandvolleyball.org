<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('validate the new admin passwords');
$I->lookForwardTo('not be able to create weak passwords');
$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');
$I->see('PVA Administration');
$I->click('Admins');

$I->seeNumberOfElements('.admins-table__row', 1);

$I->fillField('uname', 'newuser');
$I->fillField('password', 'Password');
$I->click('submit');
$I->see('Password must include at least one number!');
$I->seeNumberOfElements('.admins-table__row', 1);

$I->fillField('uname', 'newuser');
$I->fillField('password', '12345678');
$I->click('submit');
$I->see('Password must include at least one letter!');
$I->seeNumberOfElements('.admins-table__row', 1);

$I->fillField('uname', 'newuser');
$I->fillField('password', 'P1');
$I->click('submit');
$I->see('Password too short!');
$I->seeNumberOfElements('.admins-table__row', 1);

