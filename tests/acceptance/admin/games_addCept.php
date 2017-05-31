<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('add a game and see it');
$I->lookForwardTo('see the login prompt');
$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');
$I->see('PVA Administration');
$I->click('Games');
$I->seeNumberOfElements('.games-table__row', 266);
$I->selectOption('home', '1492'); // Fembots (Womens B Grass 4s)
$I->selectOption('visitor', '1512'); // Mr. Team (Sand Quads)
$I->fillField('dt','07/01/3000'); // Always last game
$I->selectOption('time', '8:00');
$I->selectOption('gym',38); // Beaverton Courts
$I->fillField('court', 'EDDIECOURT');
$I->selectOption('ref',17); // Norm
$I->click('Add Game');
$I->seeNumberOfElements('.games-table__row', 267);
$I->see('7/1/3000', '//tr[contains(@class, "games-table__row")][267]');
$I->see('8:00', '//tr[contains(@class, "games-table__row")][267]');
$I->see('Fembots', '//tr[contains(@class, "games-table__row")][267]');
$I->see('Mr. Team', '//tr[contains(@class, "games-table__row")][267]');
$I->see('Beaverton Courts', '//tr[contains(@class, "games-table__row")][267]');
$I->see('EDDIECOURT', '//tr[contains(@class, "games-table__row")][267]');
$I->see('Eddie Randolph', '//tr[contains(@class, "games-table__row")][267]');
