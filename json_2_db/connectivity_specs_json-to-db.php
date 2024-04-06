<?php 
    
    $JSONdevicesArr = file_get_contents("../devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    
    // $btLen = 0;
    // $wifiLen = 0;
    // $hotspotLen = 0;
    // $freqLen = 0;
    // $resLen = 0;
    // $usbLen = 0;
    // $clLen = 0;


    include '../dbhandler.php';

    foreach ($devicesDecode as $key => $jsons) { // This will search in the 2 jsons

        foreach($jsons as $key => $spec) {

            if ($key === '_connections') {
                foreach ($spec as $connKey=>$connSpec) {
                    switch ($connKey) {
                        case 'bluetooth':
                            $bluetooth = $connSpec;
                            // if (strlen($connSpec) > $btLen) {
                            //     $btLen = strlen($connSpec);
                            // }
                            break;

                        case 'wifi':
                            $wifi = $connSpec;
                            // if (strlen($connSpec) > $wifiLen) {
                            //     $wifiLen = strlen($connSpec);
                            // }
                            break;

                        case 'hotspot':
                            $hotspot = $connSpec;
                            // if (strlen($connSpec) > $hotspotLen) {
                            //     $hotspotLen = strlen($connSpec);
                            // }
                            break;

                        case 'frequencies':
                            $freq = $connSpec;
                            // if (strlen($connSpec) > $freqLen) {
                            //     $freqLen = strlen($connSpec);
                            // }
                            break;

                        case 'usb':
                            $usb = $connSpec;
                            // if (strlen($connSpec) > $usbLen) {
                            //     $usbLen = strlen($connSpec);
                            // }
                            break;
                    }
                }
            }
            elseif ($key === '_contactlessPay') {
                if ($spec === false ||  $spec === null || $spec === '') {
                    $contactLess = 'None';
                } else {
                    $contactLess = $spec;
                }
                
                // if (strlen($spec) > $clLen) {
                //     $clLen = strlen($spec);
                // }
            }
        }

        $sql = "INSERT INTO connectivity_specs (bluetooth, wifi, hotspot, frequencies, usb, contactless)
                VALUES ($bluetooth, '$wifi', '$hotspot', '$freq', $usb, '$contactLess')";

        $conn->query($sql);
        echo mysqli_error($conn);
   }

//    echo 'Blutooth string is ' . $btLen . ' characters', "\n";
//    echo 'Wifi string is ' . $wifiLen . ' characters', "\n";
//    echo 'Hotspot string is ' . $hotspotLen . ' characters', "\n";
//    echo 'Frequency string is ' . $freqLen . ' characters', "\n";
//    echo 'USB string is ' . $usbLen . ' characters', "\n";
// echo 'Contactless string is ' . $clLen . ' characters', "\n";

    $conn->close();
?>