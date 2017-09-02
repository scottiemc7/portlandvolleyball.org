<?php

include '/home/pva/portlandvolleyball.org/lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

buildGames();

dbclose();

        function buildGames() { // Create method of not adding BYE/Cancelled games

                $BYE_GYM = 42;
                $CANCELLED_GYM = 43;
                $BYE_TEAM = 457;
                
                //$id=$this->id;
		$id=1347;  // Fuse

                $sql=<<<EOF
(SELECT hscore1 as us1, vscore1 as them1, hscore2 as us2, vscore2 as them2, hscore3 as us3, vscore3 as them3, hmp as usmp, vmp as themmp, visitor as opponent, dt
FROM games
WHERE home = $id
AND visitor <> $BYE_TEAM
AND gym <> $BYE_GYM
AND gym <> $CANCELLED_GYM)
UNION all
(SELECT vscore1 as us1, hscore1 as them1, vscore2 as us2, hscore2 as them2, vscore3 as us3, hscore3 as them3, vmp as usmp, hmp as themmp, home as opponent, dt
FROM games
WHERE visitor = $id
AND home <> $BYE_TEAM
AND gym <> $BYE_GYM
AND gym <> $CANCELLED_GYM)
ORDER BY dt
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
                    $dt=$row['dt'];

		    /*
                    $tmp = new Game($us1,$them1,$us2,$them2,$us3,$them3,$usmp,$themmp,$opponent);
                    $this->addGame($tmp);
                    //echo "Size of gamesArray is " . sizeof($this->gamesArray) . "<br/>";
		    */
		    print <<<EOF
h=$id v=$opponent ($us1,$them1) ($us2,$them2) ($us3,$them3) [$usmp,$themmp) $dt<p />
EOF;
                  }
                
                  mysqli_free_result($result);
                }else{
                  $error=dberror();
                  print "***ERROR*** dbquery: Failed query<br />$error\n";
                  exit;
                }

        }

?>
