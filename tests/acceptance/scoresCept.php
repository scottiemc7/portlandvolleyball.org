<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the scores page');
$I->lookForwardTo('see the scores');
$I->amOnPage('/');
$I->click('Scores');
$I->see('Scores for completed games');
$I->see('21 - 15');