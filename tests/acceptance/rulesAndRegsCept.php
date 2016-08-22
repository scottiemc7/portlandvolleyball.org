<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the rules and regulations page');
$I->lookForwardTo('see the rules');
$I->amOnPage('/');
$I->click('Rules & Regs');
$I->see('PVA Policies');
$I->see('PVA Outdoor Rules');
$I->see('USA Volleyball Indoor Rules');
$I->see('USA Volleyball Outdoor Rules');
$I->see('PVA Bylaws');