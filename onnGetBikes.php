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
    $bikeStationCode=$_POST['bikeStationCode'];

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

  $bikeStations = $resultArray['bikeStations'];
  unset($resultArray);
  $bikesArray=array();
  foreach( $bikeStations[$bikeStationCode]['bikes'] as $bike)//$bikeStations[0], 0 = value from selectbox option
  {
      if(isset($bikesArray[$bike['modelName']]))
      {
          array_push($bikesArray[$bike['modelName']][1],$bike['bikeId']);
      }
      else
      {
          $bikesArray[$bike['modelName']]=array(array("name"=>$bike['manufacturerName']." ".$bike['modelName'],
                                            "bikeImage"=>$bike['bikeImage'],
                                            "allowedDistance"=>$bike['allowedDistance'],
                                            "maxSpeedLimit"=>$bike['maxSpeedLimit'],
                                            "securityDeposit"=>$bike['securityDeposit'],
                                            "tariff"=>$bike['tariff'],
                                            ),array($bike['bikeId']));
      }
      
  }



?>