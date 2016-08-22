<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the standings page');
$I->lookForwardTo('see the standings');
$I->amOnPage('/');
$I->click('Scores');
$I->see('Scores for completed games');
$I->see('21 - 15');