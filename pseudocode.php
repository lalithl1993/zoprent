
<?php
session_start();
include 'admin/config.php';
include"apiManager/apiManager.php";

//todo:get city from $_GET or sessions
$city='Bengaluru';

//todo:get from and to dates
$dateFrom='2018-07-12 09:00:00 +0530'; //On submit variable values;
$dateTo='2018-07-13 09:00:00 +0530';

//todo:send city and dates to server

//creating dropdown maybe service
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
$i=0;
//$bikeStationCodes=array();

$options="";
foreach($bikeStations as $bikeStation)
{
	$options += "<option value='".$i++."'>".$bikeStation['bikeStationArea']."</option>
	";
    //$bikeStationCodes[$bikeStation['bikeStationArea']]= $i++;
}
unset($i);


echo"
<select>
  <option>Select</option>
  ".$options." 
</select>";
//End creating dropdown

//after selecting area and click go
//server side
$bikeStations = $resultArray['bikeStations'];
unset($resultArray);
$bikesArray=array();
foreach( $bikeStations[0]['bikes'] as $bike)//$bikeStations[0], 0 = value from selectbox option
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

//todo:display all bikes in for loop
//create form with hidden fields 
//todo:on click of book button, fill all the details to form and submit 
//end of product page


// booking page
// load all data from post

$onn = getAPI("onn");
//$payload=array('fromdate'=>'vc',
//                .....,
 //               ......);
$status=0;
foreach($_POST['selectedBike'] as $bikeId)
{
    $payload['bikeId']=$bikeId;
    $response=$onn->reserveBike($payload);
    if($response!=false)
    {
        //todo do payment
        $status=1;
        break;
    }
}
if($status==0)
{
   // display error message
}


?>
