<?php
session_start();

function combineDateTime($date,$time)
{
	$gmtTimezone = new DateTimeZone("+0530");
	$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
	$myDateTime = new DateTime($combinedDT, $gmtTimezone);
	return($myDateTime->format('Y-m-d H:i:s O'));
}

function bookBike($parameters)//not used yet
{
	$onn = getAPI("onn");
	if($response=$onn->bookBike($parameters))
	{
		//booking success full
	}
	else{
		// sorry booking unsuccessfull please contact .... if money has been debited 
	}
}

function reserveBike($parameters)
{
	$onn = getAPI("onn");
		
	foreach($_SESSION["bikeId"] as $bikeId)
	{
		$parameters['bikeId']=$bikeId;
		$response=$onn->reserveBike($parameters);
		if($response!=false)
		{
			return($response);
		}
	}
	
	return(false);
	
}

if(isset($_POST['rent_now']))//called from onnproducts page
{



	$bikeName = $_POST['name'];
	$bikeImage = $_POST['bikeImage'];
	$allowedDistance = $_POST['allowedDistance'];
	$maxSpeedLimit = $_POST['maxSpeedLimit'];
	$securityDeposit = $_POST['securityDeposit'];
	$tariff = $_POST['tariff'];
	$bikeId = $_POST['bikeId'];
	$bikeStationId = $_POST['bikeStationId'];
	
		
	$_SESSION["bikeName"]=$bikeName;
	$_SESSION["bikeImage"]=$bikeImage;
	$_SESSION["allowedDistance"]=$allowedDistance;
	$_SESSION["maxSpeedLimit"]=$maxSpeedLimit;
	$_SESSION["securityDeposit"]=$securityDeposit;
	$_SESSION["tariff"]=$tariff;
	$_SESSION["bikeId"]=$bikeId;
	$_SESSION["bikeStationId"]=$bikeStationId;
	
	}
	
	
	/*if(!isset($_SESSION["bikeId"]))
	{
		
$_SESSION["bikeName"]=$bikeName;
$_SESSION["bikeImage"]=$bikeImage;
$_SESSION["allowedDistance"]=$allowedDistance;
$_SESSION["maxSpeedLimit"]=$maxSpeedLimit;
$_SESSION["securityDeposit"]=$securityDeposit;
$_SESSION["tariff"]=$tariff;
$_SESSION["bikeId"]=$bikeId;
$_SESSION["bikeStationId"]=$bikeStationId;

	}*/
	
	
	
	
	
	
	if(isset($_POST['book_now']))//clicked on submit in same page
{
	
	//todo: set variables 
	
	$dateFrom = combineDateTime($_SESSION['db_f_date'],$_SESSION['from_time']);
    $dateTo = combineDateTime($_SESSION['db_t_date'],$_SESSION['to_time']);
	
	
/*	"authToken": "5b1f666d0ed5422cfbabfb13",
  "fromDate": "2018-06-20 09:00:00 +0530",
  "toDate": "2018-06-21 09:00:00 +0530",
  "bikeId" : "A1886",
  "bikeStationId" : "BS000006",
  "customerName" : "Vishwanath S K",
  "customerEmail" : "vishwanath.sk@onnbikes.com",
  "customerPhoneNumber" : "9008729006",
  "bookingType" : "Pickup"*/
	$parameters = array (
    'fromDate' => $dateFrom,
    'toDate' => $dateTo,
    'bikeStationId' => $_SESSION["bikeStationId"],
    'customerName' => 0,
    'customerEmail' => 0,
	'customerPhoneNumber' => 0,
    'bookingType' => 0,
  );
	
	if($resposeReserve=reserveBike($parameters))
	{
		$_SESSION['reserveBookId'] = $resposeReserve['bookingId'];
		
		//call for payment
		//header('location: bookingsh.php?sub='.$_GET['sub'].'&uid='.$_GET['uid'].'&city='.$_GET['city'].'#pays'); 
		
	}
	else
	{
		//sorry bikes not available
	}

}





?>