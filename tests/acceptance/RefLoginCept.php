<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('login to the ref page');
$I->lookForwardTo('and see the info for the logged in ref');
$I->amOnPage('/ref');
$I->fillField('uname', 'waylon');
$I->fillField('pw', 'Password1');
$I->click('submit');
$I->see('PVA Administration');
