<?php
$I = new AcceptanceTester($scenario);
$I->deleteFromDatabase('home_page', []);
$I->wantTo('add articles and see them on the home page and new archives');
$I->lookForwardTo('see 5 articles on the home page and the rest on the archives page');
$I->amOnPage('/');
$I->seeNumberOfElements('article', 0);

$I->amOnPage('/admin');
$I->fillField('uname', 'pva_admin');
$I->fillField('pw', 'deep energy idea store');
$I->click('submit');


$I->see('PVA Administration');
$I->click('Home Page Articles');
$I->fillField('title','title1');
$I->fillField('article','article1');
$I->click('Add Article');

$I->amOnPage('/');
$I->seeNumberOfElements('article', 1);
$I->click('News Archives');
$I->seeNumberOfElements('article', 0);

$I->amOnPage('/admin');
$I->click('Home Page Articles');
$I->fillField('title','title2');
$I->fillField('article','article2');
$I->click('Add Article');
$I->fillField('title','title3');
$I->fillField('article','article3');
$I->click('Add Article');
$I->fillField('title','title4');
$I->fillField('article','article4');
$I->click('Add Article');
$I->fillField('title','title5');
$I->fillField('article','article5');
$I->click('Add Article');
$I->fillField('title','title6');
$I->fillField('article','article6');
$I->click('Add Article');

$I->amOnPage('/');
$I->seeNumberOfElements('article', 5);
$I->click('News Archives');
$I->seeNumberOfElements('article', 1);
