--TEST--
Bug #36599 (DATE_W3C format constant incorrect).
--FILE--
<?php

function compare($a, $b) {
    echo ($a > $b ? '$a > $b' : ($a < $b ? '$a < $b' : ($a == $b ? '$a == $b' : 'undefined'))) . "\n";
}

$dateTime = "2014-11-21 15:00:00";

echo "\nIt's a sunny afternoon in Santiago\n";
$a = new DateTime($dateTime, new DateTimeZone("America/Santiago"));

echo "\nMake new datetime \$b from \$a, but in UTC which is 3 hours ahead of Santiago\n";
$b = new DateTime($a->format(DateTime::W3C), new DateTimeZone("UTC"));
compare($a, $b);

echo "\nAdd 3 hours to \$a, meaning \$a and \$b should match \n";
$a->add(new DateInterval("PT3H"));
compare($a, $b);

echo "\nGive both dates the same timezone, meaning \$a should be in the future again \n";
$a->setTimezone($b->getTimezone());
compare($a, $b);

echo "\nCompare Timestamps:\n";
var_dump($a->getTimestamp());
var_dump($b->getTimestamp());

echo "\nExpecting \$a to be > \$b\n";
compare($a->getTimestamp(), $b->getTimestamp());

--EXPECT--
It's a sunny afternoon in Santiago
Make new datetime $b from $a, but in UTC which is 3 hours ahead of Santiago
$a == $b

Add 3 hours to $a, meaning $a and $b should match 
$a > $b

Give both dates the same timezone, meaning $a should be in the future again 
$a == $b

Compare Timestamps
int(1416603600)
int(1416592800)

Expecting $a to be > $b
$a > $b