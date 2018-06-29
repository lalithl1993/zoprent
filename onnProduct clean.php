<?php
session_start();
include 'admin/config.php';
include"apiManager/apiManager.php";
date_default_timezone_set('Asia/Calcutta');
$id=$_GET['id'];
$ids=$_GET['first'];
$uids=$_GET['uid'];//city name
//$de_code=urldecode($id);
//$de_code_arr=explode("/",$de_code);
$category=$id;
$category_id=$ids;

// to display banner and city name
$qryd=mysql_query("select * from city where city_name='$uids'");
$ress=mysql_fetch_array($qryd);
$bmg=$ress['id'];

$qry=mysql_query("select banner_image from categories where categories='$category'");
$res=mysql_fetch_array($qry);
$ban_img=$res['banner_image'];


if($ban_img=="")
{
	$ban_img="assets/bg2.png";
}
if(!isset($_SESSION['from_date']) or !isset($_SESSION['to_date']))
{
    $_SESSION['from_date']=date("d-m-Y");
    $_SESSION['db_f_date']=date("Y-m-d");
    
    $_SESSION['to_date']=date("d-m-Y", strtotime("+1 day"));
    $_SESSION['db_t_date']=date("Y-m-d", strtotime("+1 day"));
    
    
    $f_date=$_SESSION['db_f_date'];
    $t_date=$_SESSION['db_t_date'];
	
    $datetime1 = new DateTime($f_date);
    $datetime2 = new DateTime($t_date);
    $interval = $datetime1->diff($datetime2);
    $day=$interval->format('%a');
    $total_day=$day;
    if($total_day==0)
    {
        $total_day=1;
    }
    
    $_SESSION['day']=$total_day;
    
}
if(isset($_POST['search']))
{
    $from_date=$_POST['from_date'];
    $to_date=$_POST['to_date'];
    $from_time=$_POST['from_time'];
    $to_time=$_POST['to_time'];
    
    $result1=explode("-",$from_date);
    $db_from_date=$result1[2]."-".$result1[1]."-".$result1[0];
    
    $result2=explode("-",$to_date);
    $db_to_date=$result2[2]."-".$result2[1]."-".$result2[0];
    
    
    if($from_date==$to_date)
    {
        $to_date = date('d-m-Y', strtotime($to_date . " +1 day"));
        $db_to_date = date('Y-m-d', strtotime($db_to_date . " +1 day"));
    }
    
    
    
    $_SESSION['from_date']=$from_date;
    $_SESSION['db_f_date']=$db_from_date;
    
    $_SESSION['to_date']=$to_date;
    $_SESSION['db_t_date']=$db_to_date;
    
    $_SESSION['from_time']=$from_time;
    $_SESSION['to_time']=$to_time;
    
    $datetime1 = new DateTime($db_from_date." ".$from_time);
    $datetime2 = new DateTime($db_to_date." ".$from_time);
    $interval = $datetime1->diff($datetime2);
    $day=$interval->format('%a');
    $hour=$interval->format('%h');
    $total_day="";
    $total_day=$day;
    if($hour>=1)
    {
        $total_day=$day+1;
    }
    if($total_day==0)
    {
        $total_day=1;
    }
    $_SESSION['day']=$total_day;
    
}

?>
//
background: url(<?php echo $ban_img?>);
<?php include 'menu1.php';?>
//		

       <h1 style="color:#fff;font-family:ab2;">Select Your Favourite <?php if($category=='Bikes'){
                                                                               echo substr($category, 0, -1);
                                                                           }
                                                                           elseif($category=='Cars'){
                                                                               echo substr($category, 0, -1);
                                                                           }
                                                                           else {
                                                                               echo $category;
                                                                           }?> </h1>
      <h5 style="color:#fff;font-family:ab2;">Enjoy the journey!!</h5>
      
       
	  <?php
	  $city_id=$bmg;
	  $qry1=mysql_query("select DISTINCT sub_category from product_details where vendor_city='$city_id'");
	  $count1=mysql_num_rows($qry1);
      if($count1>=1)
      {
          echo '  <h3 class="about-title line-hori" id="mist" ><span style="font-size: 35px; font-family: ab2; color: #000;font-weight: bold;">'.$category.'<span style="color: #004066;">&nbsp;in&nbsp;'.$uids.'</span></span></h3>';
      }
	  
      ?>
	  
      
                                
     
                                  &emsp; &emsp; &emsp; &emsp;  Select Date & Location
                                </h3>
                                <fieldset id="account" style="margin-left:0px;">
                                    <form action="" method="POST">
                                        
                                                <label>From Date</label>
                                                <input type="text" id="from_date"value="<?php echo $_SESSION['from_date'];?>" name="from_date" onchange="change_date();">
                                            
                                                <label >From Time</label> <br/>
                                                <select name="from_time" class="form-control">
                                                    <option value="7:00:00">7:00am</option>
                                                    <option value="7:30:00">7:30am</option>
                                                    <option value="8:00:00">8:00am</option>
                                                    <option value="8:30:00">8:30am</option>
                                                    <option value="9:00:00">9:00am</option>
                                                    <option value="9:30:00">9:30am</option>
                                                    <option value="10:00:00">10:00am</option>
                                                    <option value="10:30:00">10:30am</option>
                                                    <option value="11:00:00">11:00am</option>
                                                    <option value="11:30:00">11:30am</option>
                                                    <option value="12:00:00">12:00pm</option>
                                                    <option value="12:30:00">12:30pm</option>
                                                    <option value="13:00:00">1:00pm</option>
                                                    <option value="13:30:00">1:30pm</option>
                                                    <option value="14:00:00">2:00pm</option>
                                                    <option value="14:30:00">2:30pm</option>
                                                    <option value="15:00:00">3:00pm</option>
                                                    <option value="15:30:00">3:30pm</option>
                                                    <option value="16:00:00">4:00pm</option>
                                                    <option value="16:30:00">4:30pm</option>
                                                    <option value="17:00:00">5:00pm</option>
                                                    <option value="17:30:00">5:30pm</option>
                                                    <option value="18:00:00">6:00pm</option>
                                                    <option value="18:30:00">6:30pm</option>
                                                    <option value="19:00:00">7:00pm</option>
                                                    <option value="19:30:00">7:30pm</option>
                                                    <option value="20:00:00">8:00pm</option>
                                                    <option value="20:30:00">8:30pm</option>
                                                    <option value="21:00:00">9:00pm</option>
                                                    <option value="21:30:00">9:30pm</option>
                                                    <option value="22:00:00">10:00pm</option>
                                                    <option value="22:30:00">10:30pm</option>
                                                    <option value="23:00:00">11:00pm</option>
                                                    <option value="23:30:00">11:30pm</option>
                                                </select>
                                        


                                        
                                                <label>To Date</label>
                                                <input value="<?php echo $_SESSION['to_date'];?>" name="to_date" onchange="change_date();">
                                        
                                                <label>To Time</label> <br />
                                                <select name="to_time" class="form-control">
                                                    <option value="7:00:00">7:00am</option>
                                                    <option value="7:30:00">7:30am</option>
                                                    <option value="8:00:00">8:00am</option>
                                                    <option value="8:30:00">8:30am</option>
                                                    <option value="9:00:00">9:00am</option>
                                                    <option value="9:30:00">9:30am</option>
                                                    <option value="10:00:00">10:00am</option>
                                                    <option value="10:30:00">10:30am</option>
                                                    <option value="11:00:00">11:00am</option>
                                                    <option value="11:30:00">11:30am</option>
                                                    <option value="12:00:00">12:00pm</option>
                                                    <option value="12:30:00">12:30pm</option>
                                                    <option value="13:00:00">1:00pm</option>
                                                    <option value="13:30:00">1:30pm</option>
                                                    <option value="14:00:00">2:00pm</option>
                                                    <option value="14:30:00">2:30pm</option>
                                                    <option value="15:00:00">3:00pm</option>
                                                    <option value="15:30:00">3:30pm</option>
                                                    <option value="16:00:00">4:00pm</option>
                                                    <option value="16:30:00">4:30pm</option>
                                                    <option value="17:00:00">5:00pm</option>
                                                    <option value="17:30:00">5:30pm</option>
                                                    <option value="18:00:00">6:00pm</option>
                                                    <option value="18:30:00">6:30pm</option>
                                                    <option value="19:00:00">7:00pm</option>
                                                    <option value="19:30:00">7:30pm</option>
                                                    <option value="20:00:00">8:00pm</option>
                                                    <option value="20:30:00">8:30pm</option>
                                                    <option value="21:00:00">9:00pm</option>
                                                    <option value="21:30:00">9:30pm</option>
                                                    <option value="22:00:00">10:00pm</option>
                                                    <option value="22:30:00">10:30pm</option>
                                                    <option value="23:00:00">11:00pm</option>
                                                    <option value="23:30:00">11:30pm</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>




                         <?php
                         // API data display
                        
$dateFrom='2018-07-12 09:00:00 +0530'; //On submit variable values;
$dateTo='2018-07-13 09:00:00 +0530';
$city='Bengaluru';
$area='Ulsoor';


$onn = getAPI('onn');

 $parameters = array (
  'fromDate' => $dateFrom,
  'toDate' => $dateTo,
  'cityLatitude' => 0,
  'cityLongitude' => 0,
  'cityName' => $city,
);
 $var=$onn->getAvailableBikes($parameters);
 //echo"... <br>";
 //print_r($var['bikeStations'][0]['bikes'][0]['bikeId']);
// echo json_encode($var);
 /*foreach ($var['bikeStations'] as $bikes ) {
 // 	# code...
 	echo '<br> <br>';
 	echo'<h4>'. $bikes['bikeStationName'].'</h4>';
 	echo '<br>';
 	foreach ($bikes['bikes'] as $bike) {
 		//echo 'Bike ID: '.$bike['bikeId'].' ';
 		echo $bike['modelName'].' ';
 		echo '<img src="'.$bike['bikeImage'].'" alt="image" height="119" width="189"/>';
 		echo 'Price: '.$bike['tariff'].'&emsp; &emsp;';
	 	}
	}*/

//print_r($var);

$bikeStations = $var['bikeStations'];
$i=0;
$bikeStationCodes=array();
//$areas=array();
foreach($bikeStations as $bikeStation)
{
    $bikeStationCodes[$bikeStation['bikeStationArea']]= $i++;
   // $areas=$bikeStationCodes[$bikeStation['bikeStationArea']];
}
//print_r($bikeStations['bikeStationArea']);
unset($i);
//print_r($bikeStationCodes);
//echo "<br><br><br>";
// code snippet to create bike list by providing bikestation code
$bikesArray=array();
foreach( $bikeStations[1]['bikes'] as $bike)
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
//print_r($bikesArray[$bike['modelName']]);
//print_r($bikesArray['Activa']);
//print_r($bikesArray);
echo '<h4>'.$area.'</h4>';
foreach ($bikesArray as $bike) {
	# code...
 		//echo 'Bike ID: '.$bike['bikeId'].' ';

 	//	echo $bike[0]['name'].' ';
 	//	echo '<img src="'.$bike[0]['bikeImage'].'" alt="image" height="119" width="189"/>';
 	//	echo 'Price: '.$bike[0]['tariff'].'&emsp; &emsp;';
//	print_r($bike[0]['bikeImage']);
//echo "-------END--------";

 		echo'<div class="col-md-3 col-sm-3 col-xs-12 text-center">';
										
										echo'<img src="'.$bike[0]['bikeImage'].'" alt="image" height="119" width="189"/>';

										 echo'<h4 style="font-family: ab2;"> '.$bike[0]['name'].'</h4>';

										 echo'<span style="margin-left:-20px">  Mon-Sun  </span><h4 style="margin-top: 10px;font-family: ab2;font-weight:bold;"><i class="fa fa-inr" aria-hidden="true"></i>'.$bike[0]['tariff'].'/Day'; 
									 
								echo'	</div>';
}

                         ?>

                           
						
				
					
			<?php $_SESSION['category'] = $category;?>
		
		<!-- //Main Container -->
		
		<script type="text/javascript"><!--
			var $typeheader = 'header-home5';
			//-->
		</script>
		<!-- Footer Container -->
			<?php include 'footer.php';?>
		<!-- //end Footer Container -->

    </div>
	<!-- Social widgets -->
	
	

	
	
		<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	 <script src="js/timepicki.js"></script>
    <script>
	$('#from_time').timepicki();
    </script>

	<link href="time_picker/css/timepicki.css" rel="stylesheet">
    <link href="time_picker/css/style.css" rel="stylesheet">
    <script src="time_picker/js/timepicki.js"></script>
	<script>
	$('#timepicker1').timepicki();
    </script>
	<script>
  $( function() {
    $( "#from_date").datepicker({ dateFormat: "dd-mm-yy"}).val();
    $( "#to_date").datepicker({ dateFormat: "dd-mm-yy"}).val();
  } );
  </script>
  //google code
  <script type="text/javascript">
  goog_snippet_vars = function() {
    var w = window;
    w.google_conversion_id = 848977300;
    w.google_conversion_label = "UZzwCNyM2nIQlLvplAM";
    w.google_remarketing_only = false;
  }
  goog_report_conversion = function(url) {
    goog_snippet_vars();
    window.google_conversion_format = "3";
    var opt = new Object();
    opt.onload_callback = function() {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  }
  var conv_handler = window['google_trackConversion'];
  if (typeof(conv_handler) == 'function') {
    conv_handler(opt);
  }
}
</script>
<script type="text/javascript"
  src="//www.googleadservices.com/pagead/conversion_async.js">
</script>
 
	

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="js/themejs/libs.js"></script>
    <script type="text/javascript" src="js/unveil/jquery.unveil.js"></script>
    <script type="text/javascript" src="js/countdown/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js"></script>
    <script type="text/javascript" src="js/datetimepicker/moment.js"></script>
    <script type="text/javascript" src="js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>


    <!-- Theme files
	============================================ -->
    <script type="text/javascript" src="js/themejs/application.js"></script>
    <script type="text/javascript" src="js/themejs/toppanel.js"></script>
    <script type="text/javascript" src="js/themejs/so_megamenu.js"></script>
    <script type="text/javascript" src="js/themejs/addtocart.js"></script>

    <script type="text/javascript" src="js/themejs/accordion.js"></script>
    <script type="text/javascript" src="js/themejs/cpanel.js"></script>

    <script>
        //paste this code under the head tag or in a separate js file.
        // Wait for window load
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
	 <script type="text/javascript" src="js/themejs/so_megamenu.js"></script>
	<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-97196585-1', 'auto');
		  ga('send', 'pageview');

	</script>	
 
	
	</body>
</html>