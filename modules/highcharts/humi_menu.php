<span class="belka">&nbsp Highcharts<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=humi_view&highcharts=day" ><button>day</button></a></td>
<td><a href="index.php?id=view&type=humi_view&highcharts=week" ><button>week</button></a></td>
<td><a href="index.php?id=view&type=humi_view&highcharts=month" ><button>month</button></a></td>
<td><a href="index.php?id=view&type=humi_view&highcharts=year" ><button>year</button></a></td>
</tr>
</table>



<?php $art=$_GET['highcharts']; ?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/humi_highcharts.php'); break;
case 'day': include('modules/highcharts/humi_highcharts.php'); break;
case 'week': include('modules/highcharts/humi_highcharts_week.php'); break;
case 'month': include('modules/highcharts/humi_highcharts_month.php'); break;
case 'year': include('modules/highcharts/humi_highcharts_year.php'); 
}
?>




</span>
</span>