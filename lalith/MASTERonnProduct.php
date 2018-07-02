<?php
session_start();
include 'admin/config.php';
include"apiManager/apiManager.php";
date_default_timezone_set('Asia/Calcutta');
$id=$_GET['id'];	//bike,car,stay
$ids=$_GET['first'];//city id from db
$uids=$_GET['uid'];//city name

$category=$id;
$category_id=$ids;


// displaying banner immage
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
//end banner
//sessions to manage selected dates from and to

if(!isset($_SESSION['from_date']) or !isset($_SESSION['to_date']))
{
    $_SESSION['from_date']=date("d-m-Y");
    $_SESSION['db_f_date']=date("Y-m-d");
    
    $_SESSION['to_date']=date("d-m-Y", strtotime("+1 day"));
    $_SESSION['db_t_date']=date("Y-m-d", strtotime("+1 day"));
    
	$_SESSION['to_time'] = "00:00:00";
	$_SESSION['from_time'] = "00:00:00";
	
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
//end dates session

function combineDateTime($date,$time)
{
	$gmtTimezone = new DateTimeZone("+0530");
	$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
	$myDateTime = new DateTime($combinedDT, $gmtTimezone);
	return($myDateTime->format('Y-m-d H:i:s O'));
}
/*//get dates, make api call fill areas(bike stations)
    if(isset($_POST['set_dates'])){ //check if form was submitted
        $fromDate = $_POST['from_date'];
        $fromTime = $_POST['from_time'];
        $toDate = $_POST['to_date'];
        $toTime = $_POST['to_time'];
		$city = $_POST['city'];
		
	$_SESSION['from_date']=$fromDate;
    $_SESSION['db_f_date']=date("Y-m-d",strtotime($fromDate));
    
    $_SESSION['to_date']=$toDate;
    $_SESSION['db_t_date']=date("Y-m-d", strtotime($toDate));
    
	$_SESSION['to_time'] = $toTime;
	$_SESSION['from_time'] = $fromTime;
	
	
	$dateFrom = combineDateTime($fromDate,$fromTime);
    $dateTo = combineDateTime($toDate,$toTime);

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
        //$bikeArea=$_POST['bikeArea'];

        //echo "Values are: ".$fromDate." ".$fromTime." ".$toDate." ".$toTime." ".$bikeArea." ".$uids;
    }   
   // $dateTime=$fromDate.$fromTime;
   // $date = date("Y-m-d H:i:s",$dateTime);
	
	//end set dates*/
?>



   <title>ZopRent -Self-driven Car & Motorbike Rentals-Bangalore | Goa | Mysuru | Ooty | Pondicherry | Hyderabad | Mumbai</title>
    <meta charset="utf-8">
	<meta name="msvalidate.01" content="BB36471903B1CCE02D0D60EFC38ABBC8" />
	<meta name="keywords" content="ZopRent, rent a motorbike online, rent a sports motorbike in Bangalore, rent scooty in Ooty,rent self driven car in Bangalore ">
	 <meta name="keywords" content="boostrap, responsive, html5, css3, jquery, theme, multicolor, parallax, retina, business" />
    <meta name="description" content="Rent sports motorbike, motorcycle, superbikes, Bullet online in Karnataka, Self Driven car in bangalore,Ooty,Mumbai,Hyderabad,Goa,Mysore,Pondicherry">    
<meta name="author" content="Magentech">
    <meta name="robots" content="index, follow" />

    <!-- Mobile specific metas
	============================================ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Favicon
	============================================ -->

    <link rel="shortcut icon" href="assets/small.png">

    <!-- Google web fonts
	============================================ -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700|Roboto:400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Libs CSS
	============================================ -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="js/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="css/themecss/lib.css" rel="stylesheet">
    <link href="js/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <!-- Theme CSS
	============================================ -->
    <link href="css/themecss/so_megamenu.css" rel="stylesheet">
    <link href="css/themecss/so-categories.css" rel="stylesheet">
    <link href="css/themecss/so-listing-tabs.css" rel="stylesheet">
    <!-- <link href="css/themecss/slider.css" rel="stylesheet"> -->
    <link id="color_scheme" href="css/home5.css" rel="stylesheet">
    <link id="color_scheme" href="css/home8.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jssor.slider.mini.js"></script>

    <style>
	
	.page-main-section {
    background: url(<?php echo $ban_img?>);
    position: relative;
    z-index: 1;
	width: 100%;
    background-attachment: fixed !important;
    background-repeat: no-repeat;
	padding-top: 6%;
    background-position: 50% 0px;
}
        .info_section {
            background: url(assets/b4.png) no-repeat;
        }
        
        .right_box {
            background: rgba(1, 169, 196, 0.81);
            padding: 0 20px;
        }
        
        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        
        .padding {
            padding: 80px 0;
        }
    </style>
	
	<style> 
	.fishes { 
	position:absolute; 
	z-index: -1;
	
	} 
	.fish { 
	position:relative; 
	z-index: 1000; 
	opacity: 0.8;
	 } 
</style> 
<style>
@media (max-width: 590px) {
		#mist
		{
			top:-80px !important;
			font-size: 10px;
			margin-left: -30px;
			
		}
}
</style>

    <script>
        jQuery(document).ready(function($) {

            var jssor_1_SlideoTransitions = [
                [{
                    b: 5500,
                    d: 3000,
                    o: -1,
                    r: 240,
                    e: {
                        r: 2
                    }
                }],
                [{
                    b: -1,
                    d: 1,
                    o: -1,
                    c: {
                        x: 51.0,
                        t: -51.0
                    }
                }, {
                    b: 0,
                    d: 1000,
                    o: 1,
                    c: {
                        x: -51.0,
                        t: 51.0
                    },
                    e: {
                        o: 7,
                        c: {
                            x: 7,
                            t: 7
                        }
                    }
                }],
                [{
                    b: -1,
                    d: 1,
                    o: -1,
                    sX: 9,
                    sY: 9
                }, {
                    b: 1000,
                    d: 1000,
                    o: 1,
                    sX: -9,
                    sY: -9,
                    e: {
                        sX: 2,
                        sY: 2
                    }
                }],
                [{
                    b: -1,
                    d: 1,
                    o: -1,
                    r: -180,
                    sX: 9,
                    sY: 9
                }, {
                    b: 2000,
                    d: 1000,
                    o: 1,
                    r: 180,
                    sX: -9,
                    sY: -9,
                    e: {
                        r: 2,
                        sX: 2,
                        sY: 2
                    }
                }],
                [{
                    b: -1,
                    d: 1,
                    o: -1
                }, {
                    b: 3000,
                    d: 2000,
                    y: 180,
                    o: 1,
                    e: {
                        y: 16
                    }
                }],
                [{
                    b: -1,
                    d: 1,
                    o: -1,
                    r: -150
                }, {
                    b: 7500,
                    d: 1600,
                    o: 1,
                    r: 150,
                    e: {
                        r: 3
                    }
                }],
                [{
                    b: 10000,
                    d: 2000,
                    x: -379,
                    e: {
                        x: 7
                    }
                }],
                [{
                    b: 10000,
                    d: 2000,
                    x: -379,
                    e: {
                        x: 7
                    }
                }],
                [{
                    b: -1,
                    d: 1,
                    o: -1,
                    r: 288,
                    sX: 9,
                    sY: 9
                }, {
                    b: 9100,
                    d: 900,
                    x: -1400,
                    y: -660,
                    o: 1,
                    r: -288,
                    sX: -9,
                    sY: -9,
                    e: {
                        r: 6
                    }
                }, {
                    b: 10000,
                    d: 1600,
                    x: -200,
                    o: -1,
                    e: {
                        x: 16
                    }
                }]
            ];

            var jssor_1_options = {
                $AutoPlay: true,
                $SlideDuration: 800,
                $SlideEasing: $Jease$.$OutQuint,
                $CaptionSliderOptions: {
                    $Class: $JssorCaptionSlideo$,
                    $Transitions: jssor_1_SlideoTransitions
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$
                },
                $BulletNavigatorOptions: {
                    $Class: $JssorBulletNavigator$
                }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1900);
                    jssor_1_slider.$ScaleWidth(refSize);
                } else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
	<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1945186389056283');
fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1"
src="https://www.facebook.com/tr?id=1945186389056283&ev=PageView
&noscript=1"/>
</noscript>

    <style>
        /* jssor slider bullet navigator skin 05 css */
        /*
        .jssorb05 div           (normal)
        .jssorb05 div:hover     (normal mouseover)
        .jssorb05 .av           (active)
        .jssorb05 .av:hover     (active mouseover)
        .jssorb05 .dn           (mousedown)
        */
        
        .jssorb05 {
            position: absolute;
        }
        
        .jssorb05 div,
        .jssorb05 div:hover,
        .jssorb05 .av {
            position: absolute;
            /* size of bullet elment */
            width: 16px;
            height: 16px;
            background: url('img/b05.png') no-repeat;
            overflow: hidden;
            cursor: pointer;
        }
        
        .jssorb05 div {
            background-position: -7px -7px;
        }
        
        .jssorb05 div:hover,
        .jssorb05 .av:hover {
            background-position: -37px -7px;
        }
        
        .jssorb05 .av {
            background-position: -67px -7px;
        }
        
        .jssorb05 .dn,
        .jssorb05 .dn:hover {
            background-position: -97px -7px;
        }
        /* jssor slider arrow navigator skin 22 css */
        /*
        .jssora22l                  (normal)
        .jssora22r                  (normal)
        .jssora22l:hover            (normal mouseover)
        .jssora22r:hover            (normal mouseover)
        .jssora22l.jssora22ldn      (mousedown)
        .jssora22r.jssora22rdn      (mousedown)
        */
        
        .jssora22l,
        .jssora22r {
            display: block;
            position: absolute;
            /* size of arrow element */
            width: 40px;
            height: 58px;
            cursor: pointer;
            background: url('img/a22.png') center center no-repeat;
            overflow: hidden;
        }
        
        .jssora22l {
            background-position: -10px -31px;
        }
        
        .jssora22r {
            background-position: -70px -31px;
        }
        
        .jssora22l:hover {
            background-position: -130px -31px;
        }
        
        .jssora22r:hover {
            background-position: -190px -31px;
        }
        
        .jssora22l.jssora22ldn {
            background-position: -250px -31px;
        }
        
        .jssora22r.jssora22rdn {
            background-position: -310px -31px;
        }
    </style>
    <style>
        @font-face {
            font-family: ab1;
            src: url(fonts/ab1.ttf);
        }
        
        @font-face {
            font-family: ab2;
            src: url(fonts/ab2.ttf);
        }
        
        @font-face {
            font-family: ab3;
            src: url(fonts/ab3.ttf);
        }
        
        @font-face {
            font-family: ab4;
            src: url(fonts/ab4.ttf);
        }
        
        @font-face {
            font-family: abc;
            src: url(fonts/abc.ttf);
        }
    </style>
    <style type="text/css">
        .no-js #loader {
            display: none;
        }
        
        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }
        
        .se-pre-con {
            position: fixed;
            left: 0px;
            font-family: abc;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #fff;
        }
    </style>

    <style>
        h1 {
            position: relative;
            color: rgba(0, 0, 0, .3);
        }
        
        h1:before {
            content: attr(data-text);
            position: absolute;
            overflow: hidden;
            max-width: 12em;
            white-space: nowrap;
            color: #000;
            animation: loading 8s linear;
            font-family: abc;
        }
        
        @keyframes loading {
            0% {
                max-width: 0;
            }
        }
    </style>
  <!--Popup Start-->
	<script src="pop/jquery-loader.js"></script>
    <link rel="stylesheet" href="pop/qunit/qunit/qunit.css" media="screen">
    <script src="pop/qunit/qunit/qunit.js"></script>
	<link rel="stylesheet" href="pop/remodal.css">
    <link rel="stylesheet" href="pop/remodal-default-theme.css">
    <script src="pop/remodal.js"></script>
    <script src="popremodal_test.js"></script>
    <style>
      .remodal-overlay.without-animation.remodal-is-opening,
      .remodal-overlay.without-animation.remodal-is-closing,
      .remodal.without-animation.remodal-is-opening,
      .remodal.without-animation.remodal-is-closing,
      .remodal-bg.without-animation.remodal-is-opening,
      .remodal-bg.without-animation.remodal-is-closing {
        animation: none;
      }
    </style>
	
	
	<script>
	function change_location(id)
	{
		location_user=$("#"+id).val();
		result=id.split("_");	
		sub_id=result[1];
		div_id=result[2];
		
		jQuery.ajax({
						type:"POST",
						url:"ajax.php?f=change_location",
						datatype:"text",
						data:{location_user:location_user,sub_id:sub_id,div_id:div_id},
						success:function(response)
						{
							a=response.split("*********");
							pro_details=a[0];
							terms_details=a[1];
							$("#"+div_id).empty();
							$("#"+div_id).append(pro_details);
							$("#msg"+div_id).empty();
							$("#msg"+div_id).append(terms_details);
						},
						error:function (xhr, ajaxOptions, thrownError){}
					});
		
		
	}
	</script>
	<style>
	
	
	
	</style>
	<!--Google Analytics Start-->	
	
<!--Google Analytics Start-->	
		</head>
		

<body class="common-home res layout-home1">
    <div id="wrapper" class="wrapper-full banners-effect-7">
		<!-- Header Container  -->
			<?php include 'menu1.php';?>
		<!-- //Header Container  -->
		<!-- Main Container  -->
		
		<div class="page-title page-main-section" style="padding-top: 6%; background-position: 50% 0px;">
  <div class="container padding-bottom-top-120 text-uppercase text-center" style="padding: 41px 0;">
    <div class="main-title" style="padding-top: 4%;padding-bottom: 2%;">
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
      
     </div>
  </div>
</div>
		
		<main id="content" class="page-main" style="padding-top: 4%; padding-bottom:1%">
			<div class="main-container container" style="" id="form">
	
	<div class="row ">
    <div class="col-sm-1 col-md-2"></div>
      <div class="col-xs-12 col-sm-12 col-md-112 text-center about-us about-demo-1">
	  
	  <?php
	  //display bikes in city
	  $city_id=$bmg;
	  $qry1=mysql_query("select DISTINCT sub_category from product_details where vendor_city='$city_id'");
	  $count1=mysql_num_rows($qry1);
      if($count1>=1)
      {
          echo '  <h3 class="about-title line-hori" id="mist" ><span style="font-size: 35px; font-family: ab2; color: #000;font-weight: bold;">'.$category.'<span style="color: #004066;">&nbsp;in&nbsp;'.$uids.'</span></span></h3>';
      }
	  //end
      ?>
	  
      
                                
     
        
      </div>
      <!--div class="col-sm-1 col-md-12"></div>
    </div>-->					
							 <div class="row">
						<div class="col-md-12">	
						
                            <div class="row" style="padding-top: 0%;">
                                <h3 style="text-align: left;
                    color: #004066;
                    font-size: 16px;
                    font-family: ab2;
                    font-weight: bold;
                    margin-top: 3%;">
                                  &emsp; &emsp; &emsp; &emsp;  Select Date & Location
                                </h3>
                                </div>
                            </div>
                            </div>
                                <form action="" method="POST">
                                    <fieldset id="account" style="margin-left:0px;">
                                         <div class="row">
                                        <div class="col-md-1 col-sm-12">
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group ">
                                                <label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">From Date</label>
                                                <input type="text" class="form-control" id="from_date" placeholder="From Date" value="<?php echo $_SESSION['from_date'];?>" name="from_date" onchange="change_date();" style="width: 200px;">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group input-group">
                                                <label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">From Time</label> <br />
                                                <select name="from_time" class="form-control" value="<?php $_SESSION['to_time']?>">
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


                                        <div class="col-md-2 col-sm-12">
                                            <div class="form-group ">
                                                <label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">To Date</label>
                                                <input type="text" class="form-control" id="to_date" placeholder="To Date" value="<?php echo $_SESSION['to_date'];?>" name="to_date" onchange="change_date();" style="width: 200px;">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="form-group input-group">
                                                <label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">To Time</label> <br />
                                                <select name="to_time" class="form-control" value="<?php $_SESSION['to_time']?>">
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
       <div class="col-md-2 col-sm-12">
                                                 <div class="form-group input-group">        
<input type="submit" class="btn btn-primary" id="setDates" name="setDates" value="GO!!">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset id="area" style="margin-left:0px;">
                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                </div>
                                             <div class="col-md-2 col-sm-12">
                                                 <div class="form-group input-group">
                                                     <label class="control-label" style="font-family: ab2;color: #606062;">Location: </label> <br />
                                                     <select name="bikeArea" class="form-control" >
   <?php
   //get dates, make api call fill areas(bike stations)
    if(isset($_POST['set_dates'])){ //check if form was submitted
        $fromDate = $_POST['from_date'];
        $fromTime = $_POST['from_time'];
        $toDate = $_POST['to_date'];
        $toTime = $_POST['to_time'];
		$city = $_POST['city'];
		
	$_SESSION['from_date']=$fromDate;
    $_SESSION['db_f_date']=date("Y-m-d",strtotime($fromDate));
    
    $_SESSION['to_date']=$toDate;
    $_SESSION['db_t_date']=date("Y-m-d", strtotime($toDate));
    
	$_SESSION['to_time'] = $toTime;
	$_SESSION['from_time'] = $fromTime;
	
	
	$dateFrom = combineDateTime($fromDate,$fromTime);
    $dateTo = combineDateTime($toDate,$toTime);

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
    }   
 
	
	//end set dates
?>
                                                     </select>
                                                 </div>
                                             </div>
                                       </div>
                                         <div class="col-md-2 col-sm-12">
                                    <div class="form-group input-group">
                                        <input type="submit" class="btn btn-primary" id="getBikes" name="get_bikes" value="Get Bikes!!">
                                    </div>
                                </div>
                                <input type="hidden" name="city" value="<?php $uids?>" />

                            </div>
                        </fieldset>
                    </form>
                    <div class="row">
                        <div class="col-md-12">	
	<div class="row" style="padding-top: 0%;">
                            
<?php
                         
if(isset($_POST['get_bikes']))
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
  //$bikeStationId = $resultArray['bikeStationId'];
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
											"bikeStationId"=>$bikeStations[$bikeStationCode]['bikeStationId']
                                            ),array($bike['bikeId']));
      }
      
  }
$i=1;
foreach ($bikesArray as $value) {
      if($i==1)
      {
        echo '<div class="row" style="padding-top:4%;">';
      }
?>	  
<form action="onnBookings.php" method="post" >
    <div class="col-md-3 col-sm-3 col-xs-12 text-center">
	<img src="<?php echo $value[0]['bikeImage'];?>" alt="image" height="119" width="189">
	<h4 style="font-family: ab2;"><?php$value[0]['name'];?></h4>
<!--
	<span style="margin-left:-20px">Mon-Thu</span><span style="margin-left:30px">Fri-Sun</span> <h4 style="margin-top: 10px;font-family: ab2;font-weight:bold;"><i class="fa fa-inr" aria-hidden="true"></i>'.$low_price.'/Day &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-inr" aria-hidden="true"> </i> '.$prices.'/Day</h4><p style="color:#004066;"><b>Onwards</b></p>
-->	
<h4 style="margin-top: 10px;font-family: ab2;font-weight:bold;"><i class="fa fa-inr" aria-hidden="true"> </i> <?php echo $value[0]['tarrif']; ?></h4><p style="color:#004066;"><b>Onwards</b></p>
<input type="hidden" name="name" value="<?phpecho $value[0]['name'];?>"/>
<input type="hidden" name="bikeImage" value="<?phpecho $value[0]['bikeImage'];?>"/>
<input type="hidden" name="allowedDistance" value="<?phpecho $value[0]['allowedDistance'];?>"/>
<input type="hidden" name="securityDeposit" value="<?phpecho $value[0]['securityDeposit'];?>"/>
<input type="hidden" name="tariff" value="<?phpecho $value[0]['tariff'];?>"/>
<input type="hidden" name="bikeStationId" value="<?phpecho $value[0]['bikeStationId'];?>"/>
<?php
foreach($value[1] as $bikeIdvar)
{
	echo'<input type="hidden" name="bikeId[]" value="$bikeIdvar"/>';
}

?>

										<div class="query-submit-button top30">
												
												<!--<a href="bookings.php?sub='.$vname.'&uid='.$bmg.'&city='.$uids.'">-->	
										   <input type="submit" value="Rent Now" name="rent_now" style="text-align:center;font-size:12px;color:#fff;font-family: ab2;border: 1px solid #004066;background: #004066;border-radius: 3px;
									width: 50%;
									padding: 6px 4px 6px 5px;">
									<!--</a>	-->	
										</div>
									 
									</div>	
									</form>
<?php									
      if($i==4)
       {
        echo '</div>';
        $i=0;
      }
      $i++;
}

?>

						
						
						
						
						
						</div>
						
					
						
						
						</div>
		
		</main >
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
	
	

	<link rel='stylesheet' property='stylesheet'  href='css/themecss/cpanel.css' type='text/css' media='all' />
	
	<!-- Preloading Screen -->
	<!-- <div id="loader-wrapper"> -->
		<!-- <div id="loader"></div> -->
		<!-- <div class="loader-section section-left"></div> -->
		<!-- <div class="loader-section section-right"></div> -->
	 <!-- </div> -->
	<!-- End Preloading Screen -->
	
	<!-- Include Libs & Plugins
	============================================ -->
	<!-- Placed at the end of the document so the pages load faster -->
	
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