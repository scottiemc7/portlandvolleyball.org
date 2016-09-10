<?php
$I = new AcceptanceTester($scenario);
$I->deleteFromDatabase('games', []);
$byeGymId = $I->grabFromDatabase('gyms', 'id', array('name' => 'BYE'));
$homeTeamId = $I->grabFromDatabase('teams', 'id', array('name' => 'Mr. Team'));
$visitorTeamId = $I->grabFromDatabase('teams', 'id', array('name' => 'Fembots'));
$visitorTeamId = $I->grabFromDatabase('teams', 'id', array('name' => 'Fembots'));
// Sand Quads
$I->haveInDatabase('games', [
  'dt' => '2116-06-22',
  'tm' => '6:30',
  'gym' => $byeGymId,
  'home' => $homeTeamId,
  'visitor' => $visitorTeamId
]);

$I->wantTo('create a bye and see byes displayed');
$I->lookForwardTo('see the schedules');
$I->amOnPage('/schedules.php');
$I->seeNumberOfElements('.schedule-table__row', 1);
