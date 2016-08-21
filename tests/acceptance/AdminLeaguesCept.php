<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the admin leagues page');
$I->lookForwardTo('see the leagues info');
$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');
$I->click('Leagues');
$I->see('Add league');
$I->see('Current leagues');
