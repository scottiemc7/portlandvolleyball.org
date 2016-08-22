<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('/');
$I->see('Home');
$I->see('Schedules');
$I->see('Scores');
$I->see('Standings');
