<?php 
//require

function convertDate($date,$time)
{
	$gmtTimezone = new DateTimeZone("+0530");
	$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
	$myDateTime = new DateTime($combinedDT, $gmtTimezone);
	return($myDateTime->format('Y-m-d H:i:s O'));
}

if(isset($_POST['get_areas']))
{
    $from_date=$_POST['from_date'];
    $to_date=$_POST['to_date'];
    $from_time=$_POST['from_time'];
    $to_time=$_POST['to_time'];
    $city=$_POST['city'];

    $dateFrom = convertDate($from_date,$from_time);
    $dateTo = convertDate($to_date,$to_time);

	$onn = getAPI('onn');
	 $parameters = array (
	  'fromDate' => $dateFrom,
	  'toDate' => $dateTo,
	  'cityLatitude' => 0,
	  'cityLongitude' => 0,
	  'cityName' => $city,
	);
	$resultArray=$onn->getAvailableBikes($parameters);
	unset($resultArray);
	$bikeStations = $resultArray['bikeStations'];
	$i=0;
	//$bikeStationCodes=array();
	$options="";
	foreach($bikeStations as $bikeStation)
	{
	  $options .= "<option value='".$i++."'>".$bikeStation['bikeStationArea']."</option>
	  ";
	    //$bikeStationCodes[$bikeStation['bikeStationArea']]= $i++;
	}
	unset($i);
	echo"
	<select>
	  <option>Select</option>
	  ".$options." 
	</select>";
 ?>