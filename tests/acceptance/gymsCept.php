<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the gyms page');
$I->lookForwardTo('see the gyms');
$I->amOnPage('/');
$I->click('Gyms');
$I->see('PVA Gyms / Playing Locations');
$I->see('Beaverton Courts');
$I->see('14523 SW Millikan Way, Beaverton');
