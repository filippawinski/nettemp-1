<?php
$root=$_SERVER["DOCUMENT_ROOT"];
$db = new PDO("sqlite:$root/dbf/nettemp.db");
$rows = $db->query("SELECT * FROM sensors WHERE minmax='on'");
$result = $rows->fetchAll();
$numRows = count($result);
if ( $numRows > '0' ) { ?>

<div class="grid-item">
<div class="panel panel-default">
<div class="panel-heading">Sensors Min Max</div>
<div class="table-responsive">
<table class="table table-hover table-condensed">
<tbody>
<tr><small>
   <th></th>
   <th><small>Hour</small></th>
    <th><small>Day</small></th>
    <th><small>Week</small></th>
    <th><small>Month</small></th>
</tr>
<?php
foreach ($result as $a) {

$rom=$a['rom'];
$file=$rom .".sql";


    $db1 = new PDO("sqlite:$root/db/$file");
    $h = $db1->query("select min(value) AS hmin, max(value) AS hmax from def WHERE time BETWEEN datetime('now','localtime','-1 hour') AND datetime('now','localtime')") or die('hour');
    $h = $h->fetch(); 
    $d = $db1->query("select min(value) AS dmin, max(value) AS dmax from def WHERE time BETWEEN datetime('now','localtime','-1 day') AND datetime('now','localtime')") or die('day');
    $d = $d->fetch(); 
    $w = $db1->query("select min(value) AS wmin, max(value) AS wmax from def WHERE time BETWEEN datetime('now','localtime','-7 day') AND datetime('now','localtime')") or die('week');
    $w = $w->fetch(); 
    $m = $db1->query("select min(value) AS mmin, max(value) AS mmax from def WHERE time BETWEEN datetime('now','localtime','-1 months') AND datetime('now','localtime')") or die('week');
    $m = $m->fetch(); 

    echo "<tr>
	<td><small>".$a['name'] ."</small></td>
	<td><small><span class=\"label label-info\">".$h['hmin']."</span><span class=\"label label-warning\">".$h['hmax']."</span></small></td>
	<td><small><span class=\"label label-info\">".$d['dmin']."</span><span class=\"label label-warning\">".$d['dmax']."</span></small></td>
	<td><small><span class=\"label label-info\">".$w['wmin']."</span><span class=\"label label-warning\">".$w['wmax']."</span></small></td>
	<td><small><span class=\"label label-info\">".$m['mmin']."</span><span class=\"label label-warning\">".$m['mmax']."</span></small></td>
	</tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<?php 
}
?>