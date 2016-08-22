<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the winner page');
$I->lookForwardTo('see the winners');
$I->amOnPage('/');
$I->click('Winners');
$I->see('Playoff Winners');
