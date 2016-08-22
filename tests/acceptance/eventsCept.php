<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the events page');
$I->lookForwardTo('see the events');
$I->amOnPage('/');
$I->click('Events');
$I->see('There are no events to display.');
