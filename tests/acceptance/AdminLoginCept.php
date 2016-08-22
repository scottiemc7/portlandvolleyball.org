<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the admin page while not logged in');
$I->lookForwardTo('see the login prompt');
$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');
$I->see('PVA Administration');
