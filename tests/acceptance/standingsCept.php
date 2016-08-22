<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the standings page');
$I->lookForwardTo('see the standings');
$I->amOnPage('/');
$I->click('Standings');
$I->see('Standings are calculated according to the PVA Rules.');
