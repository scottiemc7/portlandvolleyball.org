<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('go to the admin page while not logged in');
$I->lookForwardTo('see the login prompt');
$I->amOnPage('/admin');
$I->see('Login');
$I->see('Password');
