<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the schedules page');
$I->lookForwardTo('see the schedules');
$I->amOnPage('/');
$I->click('Schedules');
$I->see('For scheduling questions');
$I->see('Brentwood Park (Norm)');
$I->see('Fembots');
$I->seeNumberOfElements('.schedule-table__row', 259);