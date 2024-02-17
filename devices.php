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
    $JSONdevicesArr = file_get_contents("devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    //Scope variable to store selection of devices
    $selectArr = [];
    $clientIp = $_SERVER['REMOTE_ADDR'];
    $clientDate = date("Y-m-d");
    $clientTime = date("h:i:sa");

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

    //Call database and store user's inputs (IP address + options selection)
    //Resource: https://www.codexworld.com/how-to/get-user-ip-address-php/
    include 'dbhandler.php'; //Create connection

    // FOR DEBUGGING PURPOSES ONLY: Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // FOR DEBUGGING PURPOSES ONLY:
    // echo "Connected successfully";
    $sql = "INSERT INTO response (log_time, log_address, key_feature, scr_size, batt_cap)
    VALUES ('$clientDate.$clientTime', '$clientIp', '$phpKeyFeat', '$phpScreenSize', '$phpBattCap')";
    
    $conn->query($sql);
    // $conn->close();
    
    // FOR DEBUGGING PURPOSES ONLY:
    // if ($conn->query($sql) === TRUE) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }

    $conn->close();

    foreach ($devicesDecode as $item) {

        switch ($phpKeyFeat) {
            case "camera":

                if ($item['_mainCamFeats']['camRes'] >= 8 || $item['_mainCamFeats']['camExp']['lenseWidth'] < 29 || $item['_mainCamFeats']['ois'] || $item['_mainCamFeats']['opticalZoom'] || $item['_mainCamFeats']['hdr'] || $item['_storage']['builtIn'][0] >= 32 && $item['_storage']['ext'] == true) {
                    array_push($selectArr, $item);
                    // if ($item['_name'] === "KEYone") {
                    //     echo "BLACKBERRY KEYONE!!!";
                    // }
                }
                
                break;
    
            case "screen":
                //Push in screens using AMOLED technology AND 2K resolution (1920x1080 pixels)
                //Reference: https://www.quora.com/What-is-the-best-display-of-a-smartphone
                if ($item['_screen']['type'] == 'AMOLED' || $item['_screen']['type'] == 'Super AMOLED' || $item['_screen']['type'] == 'P-OLED' && $item['_screen']['res'] == '1080 x 1920' || $item['_screen']['res'] == '1080 x 2340' ||$item['_screen']['res'] == '1440 x 2960' || $item['_screen']['res'] == '1440 x 3120' ) {
                    array_push($selectArr, $item);
                }
                break;

            case "basic":
                //Check that "_gps" array contains the values "A-GPS" AND "GLONASS" AND has an basic LCD display                
                if (in_array("A-GPS", $item['_gps']) && in_array("GLONASS", $item['_gps']) && $item['_screen']['type'] === "IPS LCD" || $item['_screen']['type'] === "LED-backlit IPS LCD") {
                    array_push($selectArr, $item);
                }
                break;
        };
    };

    foreach ($selectArr as $device) {

        switch ($phpScreenSize) {
            case "small":
                if ($phpBattCap != 'high') {
                    if ($device['_screen']['size'] > 5.0) {
                        array_splice($selectArr, array_search($device, $selectArr),1);
                    }
                } else {
                    if ($device['_screen']['size'] > 5.9) {
                        array_splice($selectArr, array_search($device, $selectArr),1);
                    }
                }
                
                break;

            case "large":
                if ($device['_screen']['size'] < 5.0) {
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
            if ($device['_devBattery']['mAhCapacity'] < 3000) {
                // if ($device['_name'] === "KEYone") {
                //     echo "BLACKBERRY KEYONE!!!";
                // }
                // echo 'Battery cap. below 3000';
                array_splice($selectArr, array_search($device, $selectArr),1);
            }
        };
        // echo 'Filtered out battery cap., selected Array counts: '.count($selectArr).'</br>';
    };

    if ($phpKeyFeat == 'camera') {

        function sortDevices($a,$b)
        {
        if ($a['_mainCamFeats']['camRes'] == $b['_mainCamFeats']['camRes']) return 0;
        return ($b['_mainCamFeats']['camRes'] < $a['_mainCamFeats']['camRes'])?-1:1;
        };

        usort($selectArr,"sortDevices");

    } else if ($phpScreenSize == 'small' || $phpScreenSize == 'large') {

        function sortDevices($a,$b)
        {
        if ($a['_screen']['size'] == $b['_screen']['size']) return 0;
        return ($b['_screen']['size'] < $a['_screen']['size'])?-1:1;
        };

        usort($selectArr,"sortDevices");

    }
    // else if ($phpBattCap == 'high') {
    //     function sortDevices($a,$b)
    //     {
    //     if ($a['_devBattery']['mAhCapacity'] == $b['_devBattery']['mAhCapacity']) return 0;
    //     return ($b['_devBattery']['mAhCapacity'] < $a['_devBattery']['mAhCapacity'])?-1:1;
    //     };

    //     usort($selectArr,"sortDevices");
    // }

    $selectArr = array_splice($selectArr, 0, 3);

    // foreach ($selectArr as $phone) {
    //     echo $phone['_name'];
    // }
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
  <link rel="stylesheet" href="/css/main.css">

  <style>
    body {background: floralwhite}
  </style>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-9573519566042715",
          enable_page_level_ads: true
     });
</script>
  
</head>

<body>

    <?php include 'includes/navbar.php';?>

    <h1 class="res-hd-title">We recommend these devices:</h1>

    <div class="dev-cards-ctn">

        <?php foreach ($selectArr as $item) :?>

            <div class="dev-card">
                <img src="<?= $item['imgUrl'] ?>" alt="<?= $item['_brand'] + $item['_name'] ?>">
                <div class="caption">
                    <h5><?= $item['_brand'] . " " . $item['_name'] ?></h5>

                    <? if ($item['amaffilink']): ?>
                        <a href="<?= $item['amaffilink'] ?>" class="affil-btn" target="_blank">Buy on Amazon!</a>
                    <? endif; ?>

                </div>
                
            </div>

        <?php endforeach ?>

    </div>

    <a href="/">
        <button id="startAgainBtn" class="custom-btn">Start again</button>
    </a>

    <?php include 'includes/footer.php';?>

    <script>

        var captionDiv = document.getElementsByClassName("caption");
        for (var i=0; i<captionDiv.length; i++) {
            if (captionDiv[i].querySelector(".affil-btn")) {
                captionDiv[i].classList.add("expanded")
            }
        }

    </script>

</body>
</html>