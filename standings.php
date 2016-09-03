<?php

include("header.html");
include 'lib/mysql.php';
?>
<div id="content" class="container">
<h1>Standings</h1>
<p>Standings are calculated according to the <a href="pvarules.php#standings">PVA Rules.</a></p>
<p>Standings will fluctuate and may not be representative as teams will have played different numbers of games.</p>
<p>Go to the <a href="scores.php">scores page</a> to see game results.</p>

<?php
$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

// Build array of leagues

$sql=<<<EOF
SELECT id, name
FROM leagues
WHERE active = 1
ORDER BY name
EOF;

$leagues = array();
if($result=dbquery($sql)) {
  while($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $name=$row['name'];
    $leagues[$name] = new League($id,$name);
  }
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

// Build array of teams for each element of leagues array

foreach($leagues as $leagueName => $league) {
  $lid=$league->getId();

  $sql=<<<EOF
SELECT id, name
FROM teams
WHERE league = $lid
EOF;

  if($result=dbquery($sql)) {
    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];

      $tmp = new Team($id,$name);
      $tmp->buildGames();
      $leagues[$leagueName]->addTeam($tmp);
    }
    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

}

print '<p style="text-align: center;">';
foreach ($leagues as $dis) {
  if(sizeof($dis->teamArray) > 0) {

    $name=$dis->name;
    print <<<EOF
<a class="btn btn-default" style="margin: 5px;" href="#$name">$name</a>

EOF;
  ++$i;
}
}
print "</p>";

//$echoteam = $leagues['nor\'easter']->getTeamById($currTeamId);
//echo "getting team in league: " . $echoteam->getName() . "<br />";
//echo "size of leagues['nor'easter']->teamArray: " . sizeof($leagues['nor\'easter']->teamArray) . "<br />";

foreach ($leagues as $dis) {
  if(sizeof($dis->teamArray) > 0) {

    $name=$dis->name;
    print <<<EOF
<h3><a name="$name">$name</a></h3>
<div class="table-responsive">
<table class="table table-striped">
<tr>
  <th align=center>Team</th>
  <th align=center>Wins</th>
  <th align=center>Losses</th>
  <th align=center>Winning<br />Percentage</th>
  <th align=center>Match<br />Points</th>
  <th align=center>Match<br />Points<br />Possible</th>
  <th align=center>Match<br />Point<br />Percentage</th>
  <th align=center></th>
</tr>

EOF;

    $dis->leagueSort();
    foreach ($dis->teamArray as $team) {
      $name=$team->getName();
      $totalWins=$team->getTotalWins();
      $totalLosses=$team->getTotalLosses();
      $totalWinPct=number_format($team->getTotalWinPct() * 100, 2);
      $totalMatchPoints=$team->getTotalMatchPoints();
      $possMatchPoints=$team->getPossMatchPoints();
      $totalMatchPct=number_format($team->getTotalMatchPct() * 100, 2);
      $tie="";
      if($team->tiesArray) {
        $tie="tie";
      }

      print <<<EOF
<tr>
  <td>$name</td>
  <td align=center>$totalWins</td>
  <td align=center>$totalLosses</td>
  <td align=center>$totalWinPct</td>
  <td align=center>$totalMatchPoints</td>
  <td align=center>$possMatchPoints</td>
  <td align=center>$totalMatchPct</td>
  <td>$tie</td>
</tr>
EOF;
    }

    print  "</table></div>";
  }
}

dbclose();

/*********************************************************
The League class
*********************************************************/
class League {
	var $id;
	var $name;
	var $winPct;
	var $matchPts;
	function League($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}

	function getTeamById($teamId) {
		//echo "sizeof teamArray: " . sizeof($this->teamArray) . "<br />";
		//echo $tmp = $this->teamArray[$teamId]->getName() . " Eek!";
		return $this->teamArray[$teamId];
	}

	function getName() {
		return $this->name;
	}

	function getId() {
		return $this->id;
	}

	function addTeam($team) {
		$this->teamArray[$team->id] = $team;
		//echo "New team added. name: " . $this->teamArray[$team->id]->getName() . "<br />";
	}

	function teamCmp($a, $b) {
		//echo "In teamCmp, a's gamesArray is " . sizeof($a->gamesArray) . "<br/>";
		if ($c = $this->winPct($a, $b)) { return $c; }
		else if ($c = $this->matchPct($a, $b)) { return $c; }
		else if ($c = $this->head2Head($a, $b)) { return $c; }
		else if ($c = $this->ptsAllowedOpponent($a, $b)) { return $c; }
		else if ($c = $this->ptsAllowed($a, $b)) { return $c; }
		else if ($c = $this->ptsDifferential($a, $b)) { return $c; }
		else {
			$a->addTie($b->id);
			$b->addTie($a->id);
			return 0; // temporary
		}
	}

	function winPct($a, $b) {
		//echo "In winPct, size of a's gamesArray is " . sizeof($a->gamesArray) . "<br/>";
		$ap = $a->getTotalWinPct();
		$bp = $b->getTotalWinPct();
		if ($ap == $bp) { return 0; }
		else { return $ap > $bp ? 1 : -1; }
	}

	function matchPct($a, $b) {
		$ap = $a->getTotalMatchPct();
		$bp = $b->getTotalMatchPct();
		if ($ap == $bp) { return 0; }
		else { return $ap > $bp ? 1 : -1; }
	}

	function head2Head($a, $b) {
		$ap = $a->getOpponentWinPct($b);
		$bp = $b->getOpponentWinPct($a);
		if ($ap == $bp) { return 0; }
		else { return $ap > $bp ? 1 : -1; }
	}

	function ptsAllowedOpponent($a, $b) {
		$ap = $a->getPointsAllowedOpponent($b);
		$bp = $b->getPointsAllowedOpponent($a);
		if ($ap == $bp) { return 0; }
		else { return $ap < $bp ? 1 : -1; }
		// NOTE!! this one is reversed: the greater number of allowed points LOSES
	}

	function ptsAllowed($a, $b) {
		$ap = $a->getTotalPointsAllowed();
		$bp = $b->getTotalPointsAllowed();
		if ($ap == $bp) { return 0; }
		else { return $ap < $bp ? 1 : -1; }
		// NOTE!! this one is reversed: the greater number of allowed points LOSES
	}

	function ptsDifferential($a, $b) {
		$ap = $a->getTotalPoints();
		$bp = $b->getTotalPoints();
		if ($ap == $bp) { return 0; }
		else { return $ap > $bp ? 1 : -1; }
	}

	function leagueSort() {
		/*echo "<h3>Sorting some teams! Calling leagueSort()!</h3><br />";
		foreach ($this->teamArray as $gnark) {
			echo "In leagueSort, spewing sizes: " . sizeof($gnark->gamesArray) . "<br/>";
		}*/
		if (! usort($this->teamArray, array(&$this, "teamCmp"))) die("Hey, usort failed!");
		$this->teamArray = array_reverse($this->teamArray);
		//foreach ($this->teamArray as $curr) echo "*" . $curr->getName() . "<br />";
	}
}

/******************************************************
The Team class
******************************************************/
class Team {
	var $id;
	var $name;
	var $league;
	var $gamesArray;
	var $gameCount;
	var $tiesArray;

	function Team($id, $name) {
		$this->id = $id;
		$this->name = $name;
		$this->gamesArray = array();
		//echo "New team created: id: " . $this->id . " name: " . $this->name . "<br />";
	}

	function addTie($id) {
		$this->tiesArray[] = $id;
	}

	function addGame($game) {
		$this->gamesArray[] = $game;
	}

	function getTies($id) {
		return  $this->tiesArray;
	}

	function getName() {
		return $this->name;
	}

	function getTotalWins() {
		$won = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $game) {
			if ($game->usmp > $game->themmp) { ++$won; }
		}
		return $won;
	}

	function getTotalLosses() {
		$lost = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $game) {
			if ($game->usmp < $game->themmp) { ++$lost; }
		}
		return $lost;
	}

	function buildGames() { // Create method of not adding BYE/Cancelled games

		$BYE_GYM = 42;
		$CANCELLED_GYM = 43;
		$BYE_TEAM = 457;

		$id=$this->id;

                $sql=<<<EOF
(SELECT hscore1 as us1, vscore1 as them1, hscore2 as us2, vscore2 as them2, hscore3 as us3, vscore3 as them3, hmp as usmp, vmp as themmp, visitor as opponent
FROM games
WHERE home = $id
AND visitor <> $BYE_TEAM
AND gym <> $BYE_GYM
AND gym <> $CANCELLED_GYM)
UNION all
(SELECT vscore1 as us1, hscore1 as them1, vscore2 as us2, hscore2 as them2, vscore3 as us3, hscore3 as them3, vmp as usmp, hmp as themmp, home as opponent
FROM games
WHERE visitor = $id
AND home <> $BYE_TEAM
AND gym <> $BYE_GYM
AND gym <> $CANCELLED_GYM)
EOF;

                if($result=dbquery($sql)) {

                  while($row=mysqli_fetch_assoc($result)) {
                    $us1=$row['us1'];
                    $them1=$row['them1'];
                    $us2=$row['us2'];
                    $them2=$row['them2'];
                    $us3=$row['us3'];
                    $them3=$row['them3'];
                    $usmp=$row['usmp'];
                    $themmp=$row['themmp'];
                    $opponent=$row['opponent'];

                    $tmp = new Game($us1,$them1,$us2,$them2,$us3,$them3,$usmp,$themmp,$opponent);
                    $this->addGame($tmp);
		    //echo "Size of gamesArray is " . sizeof($this->gamesArray) . "<br/>";
                  }

                  mysqli_free_result($result);
                }else{
                  $error=dberror();
                  print "***ERROR*** dbquery: Failed query<br />$error\n";
                  exit;
                }

	}

	function getTotalPoints() {
		$pts = 0;
		//if (sizeof($this->gamesArray) == 0) { echo "gots no games to tally<br/>"; return 0; }
		foreach($this->gamesArray as $game) {
			$pts += $game->getUsPoints();
		}
		return $pts;
	}

	function getTotalMatchPoints() {
		$pts = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $curr) {
			$pts += $curr->getUsMatchPoints();
		}
		return $pts;
	}

	function getTotalWinPct() {
		$gamesWon = 0;
		$gamesPlayed = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $game) {
			if ($game->isCompleted()) { ++$gamesPlayed; }
			if ($game->wonGame()) { ++$gamesWon; }
		}
		if ($gamesPlayed == 0 ) { return 0; }
		else { return $gamesWon / $gamesPlayed; }
	}

	function getOpponentWinPct($id) {
		$wins = 0;
		$gamesPlayed = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach($this->gamesArray as $game) {
			if ($game->opponentId == $id && $game->isCompleted()) {
				++$gamesPlayed;
				if ($game->wonGame()) { ++$wins; }
			}
		}
		if ($gamesPlayed == 0) { return 0; }
		else { return $wins / $gamesPlayed; }
	}

	function getPointsAllowedOpponent($id) {
		$ptsAllowed = 0;
		if (sizeof($this->gamesArray == 0)) { return 0; }
		foreach ( $this->gamesArray as $game) {
			if ($game->opponentId == $id) {
				$ptsAllowed += $game->getOppPoints();
			}
		}
		return $ptsAllowed;
	}

	function getTotalPointsAllowed() {
		$ptsAllowed = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $game) {
			$ptsAllowed += $game->getOppPoints();
		}
		return $ptsAllowed;
	}

	function getTotalMatchPct() {
		$gamesPlayed = 0;
		$matchPtsObtained = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $game) {
			if ($game->isCompleted()) {
				$gamesPlayed += 1;
				$matchPtsObtained += $game->usmp;
			}
		}
		if ($gamesPlayed == 0) { return 0; }
		else {
			$matchPtsPossible = $gamesPlayed * 4.5;
			return $matchPtsObtained / $matchPtsPossible;
		}
	}

	function getPossMatchPoints() {
		$gamesPlayed = 0;
		if (sizeof($this->gamesArray) == 0) { return 0; }
		foreach ($this->gamesArray as $game) {
			if ($game->isCompleted()) {
				$gamesPlayed += 1;
			}
		}
		if ($gamesPlayed == 0) { return 0; }
		else {
			$matchPtsPossible = $gamesPlayed * 4.5;
			return $matchPtsPossible;
		}
	}
}



/*****************************************************************
The Game class, which encapsulates the data of an individual game
*****************************************************************/
class Game {
	var $opponentId;
	var $us1;
	var $us2;
	var $us3;
	var $them1;
	var $them2;
	var $them3;
	var $won;
	var $usmp;
	var $themmp;

	function Game($us1, $us2, $us3, $them1, $them2, $them3, $usmp, $themmp, $opponent) {
		$this->us1 = $us1; $this->us2 = $us2; $this->us3 = $us3;
		$this->them1 = $them1; $this->them2 = $them2; $this->them3 = $them3;
		$this->usmp = $usmp;
		$this->themmp = $themmp;
		$this->won = $this->usmp > $this->themmp;
		$this->opponentId = $opponent;
		//echo "We played against $opponent <br />";
	}

	function getUsPoints() {
		return $this->us1 + $this->us2 + $this->us3;
	}

	function getOppPoints() {
		return $this->them1 + $this->them2 + $this->them3;
	}

	function getUsMatchPoints() {
		return $this->usmp;
	}

	function wonGame() {
		return $this->won;
	}

	function isCompleted() {
		$retval =  (($this->us1 != '') && ($this->them1 != ''));
		$retval =  $retval && (($this->us1 != 0) || ($this->them1 != 0));
		return $retval;
	}
}

?>
