<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the rules and regulations page');
$I->lookForwardTo('see the rules');
$I->amOnPage('/');
$I->click('Rules');
$I->click('PVA Policies');
$I->see('Portland Volleyball Association - Playing Regulations');
$I->see('USA Volleyball Rules will be followed, with the following differences');