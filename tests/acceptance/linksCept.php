<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the rules and regulations page');
$I->lookForwardTo('see the rules');
$I->amOnPage('/');
$I->click('Links');
$I->see('Eastbay.com');