<?php
    //Recovering data from POST
    $postdata = file_get_contents("php://input");
    $postdecode =  urldecode($postdata);
    $trimPost = trim($postdecode,'ParamArray=[]&sendParam=Let\'s do it!');
    $trimPost = str_replace('"','',$trimPost);
    //Arranging POST data into array
    $array = explode(",",$trimPost);
    // echo $array;
    //Scope variables to store paramaters
    $phpKeyFeat = null;
    $phpScreenSize = null;
    $phpBattCap = null;
    //Recovering JSON data for devices
    // $JSONdevicesArr = file_get_contents("devices.json");
    // $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    //Scope variable to store selection of devices
    $selectArr = [];
    // $clientIp = $_SERVER['REMOTE_ADDR'];
    // $clientDate = date("Y-m-d");
    // $clientTime = date("h:i:sa");
    global $sql;

    function setParams() {

        global $phpKeyFeat;
        global $phpScreenSize;
        global $phpBattCap;
        global $array;

        foreach ($array as $key => $val) {

            switch ($key) {
                case 0:
                    $postParam1 = $val;
    
                    switch($postParam1) {
                        case "1A":  $phpKeyFeat = 'screen';
                        break;
                    
                        case "1B": $phpKeyFeat = 'camera';
                        break;
    
                        case "1C": $phpKeyFeat = 'basic';
                        break;
                    };
                    // echo 'Key feature: '.$phpKeyFeat.',</br>';
                    break;
                case 1:
                    $postParam2 = $val;
    
                    switch ($postParam2) {
                        case "2A": $phpScreenSize = 'small';
                        break;
                        
                        case "2B": $phpScreenSize = 'large';
                        break;
                    };
                    // echo 'Screen size: '.$phpScreenSize.',</br>';
                    break;
                case 2:
                    $postParam3 = $val;
    
                    switch ($postParam3) {
                        case "3A": $phpBattCap = 'standard';
                        break;
            
                        case "3B": $phpBattCap = 'high';
                        break;
            
                        case "3C": $phpBattCap = 'standard';
                        break;
    
                        default: $phpBattCap = 'couldn\'t set up';
                    };
    
                    // echo 'Battery capacity: '.$phpBattCap;
                    return $phpBattCap;
                    break;
                    
                    default: echo 'default foreach';
            }
        };
    };

    setParams();

    include 'dbhandler.php'; //Create connection

    // FOR DEBUGGING PURPOSES ONLY: Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    switch ($phpKeyFeat) {
        case "camera":

            $sql = "SELECT *
                    FROM primary_cam_specs
                    INNER JOIN battery_specs ON battery_specs.id = primary_cam_specs.id
                    INNER JOIN core_specs ON core_specs.id = battery_specs.id
                    INNER JOIN scr_specs ON scr_specs.id = core_specs.id
                    INNER JOIN devices ON devices.id = scr_specs.id
                    WHERE primary_cam_specs.camRes >= 8 OR primary_cam_specs.lensWidth < 29 OR primary_cam_specs.OIS = 1 OR primary_cam_specs.opticZoom = 1 OR primary_cam_specs.hdr = 1
                    OR core_specs.min_builtIn_str >= 32 OR core_specs.ext_str_cap >= 64";
            
            break;

        case "screen":

            $sql = "SELECT *
                    FROM scr_specs
                    INNER JOIN battery_specs ON battery_specs.id = scr_specs.id
                    INNER JOIN core_specs ON core_specs.id = battery_specs.id
                    INNER JOIN devices ON devices.id = core_specs.id
                    WHERE scr_specs.scr_type = 'AMOLED' OR scr_specs.scr_type = 'Super AMOLED' OR scr_specs.scr_type = 'P-OLED'
                    AND scr_specs.scr_res = '1080 x 1920' OR scr_specs.scr_res = '1080 x 2340' OR scr_specs.scr_res = '1440 x 2960' OR scr_specs.scr_res = '1440 x 3120'";

            break;

        case "basic":
            
            //Check that "_gps" array contains the values "A-GPS" AND "GLONASS" AND has an basic LCD display                
            $sql = "SELECT *
                    FROM gps_specs
                    INNER JOIN battery_specs ON battery_specs.id = gps_specs.id
                    INNER JOIN core_specs ON core_specs.id = battery_specs.id
                    INNER JOIN scr_specs ON scr_specs.id = core_specs.id
                    INNER JOIN devices ON devices.id = scr_specs.id
                    WHERE gps_specs.has_a_gps = 1 AND gps_specs.has_glonass = 1 AND scr_specs.scr_type = 'IPS LCD' OR scr_specs.scr_type = 'LED-backlit IPS LCD'";
            
            break;
    };

    //Querying DB via MySQL
    $result = $conn->query($sql);
    //Create array with SQL outputs
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($selectArr, $row);
        }
    } else {
        echo "0 results";
    }

    //Closing MySQL connexion
    $conn->close();

    //Refining SQL results array
    foreach ($selectArr as $device) {

        switch ($phpScreenSize) {
            case "small":
                if ($phpBattCap != 'high') {
                    if ($device['scr_size'] > 5.0) {
                        array_splice($selectArr, array_search($device, $selectArr),1);
                    }
                } else {
                    if ($device['scr_size'] > 5.9) {
                        array_splice($selectArr, array_search($device, $selectArr),1);
                    }
                }
                
                break;

            case "large":
                if ($device['scr_size'] < 5.0) {
                    array_splice($selectArr, array_search($device, $selectArr),1);
                }
                break;
        }

        ///////////////////////////////////
        ///// DO NOT DELETED BELOW ////////
        ///////////////////////////////////
        //Battery technology: http://blog.ravpower.com/2017/06/lithium-ion-vs-lithium-polymer-batteries/
        //"Best battery life phones 2019": https://www.techadvisor.co.uk/test-centre/mobile-phone/best-battery-life-phone-3679230/
        // Li-Ion batteries has more power than Li-Po but are heavier: https://www.quora.com/Which-type-of-battery-for-smartphone-is-better-Li-Ion-or-Li-Po
        if ($phpBattCap == 'high') {
            //Restrain to mAh battery capacity above 3000
            if ($device['mAh_cap'] < 3000) {
                array_splice($selectArr, array_search($device, $selectArr),1);
            }
        };
    };

    //Sorting SQL array according to criteria
    //Sorting according camera features
    if ($phpKeyFeat == 'camera') {

        function sortDevices($a,$b)
        {
            if ($a['camRes'] == $b['camRes']) return 0;
            return ($b['camRes'] < $a['camRes'])?-1:1;
        };

        usort($selectArr,"sortDevices");

    }
    //Sorting according to screen features
    else if ($phpScreenSize == 'small' || $phpScreenSize == 'large') {

        function sortDevices($a,$b)
        {
            if ($a['scr_size'] == $b['scr_size']) return 0;
            return ($b['scr_size'] < $a['scr_size'])?-1:1;
        };

        usort($selectArr,"sortDevices");

    }
    //Sorting according to battery features
    else if ($phpBattCap == 'high') {
        function sortDevices($a,$b)
        {
            if ($a['mAh_cap'] == $b['mAh_cap']) return 0;
            return ($b['mAh_cap'] < $a['mAh_cap'])?-1:1;
        };

        usort($selectArr,"sortDevices");
    }

    //Retaining top 3 for selection array
    $selectArr = array_splice($selectArr, 0, 3);

?>
<!DOCTYPE html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Celleo - smartphone purchase virtual advisor</title>
  <meta name=”robots” content=”noindex, nofollow”>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- <link rel="manifest" href="site.webmanifest"> -->
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.min.css">

  <style>
    body {background: floralwhite}
  </style>
  
</head>

<body class="m-0">

    <?php include 'includes/navbar.php';?>

    <main id="devices-ctn">
        <div class="container">
            <div class="row">
                <div class="col-12  my-5">

                    <h1 class="res-hd-title">We recommend these devices:</h1>

                    <div class="dev-cards-ctn">

                        <?php foreach ($selectArr as $item) :?>

                            <div class="dev-card">
                                <img src="<?= $item['image'] ?>" alt="<?= $item['brand'] . ' ' . $item['name'] ?>"/>
                                <div class="caption">
                                    <h5><?= $item['brand'] . " " . $item['name'] ?></h5>
                                </div>
                                
                            </div>

                        <?php endforeach ?>

                    </div>

                    <a href="./">
                        <button id="startAgainBtn" class="custom-btn">Start again</button>
                    </a>

                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php';?>

</body>
</html>