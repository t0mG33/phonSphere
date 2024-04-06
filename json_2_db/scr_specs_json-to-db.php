<?php 
    
    $JSONdevicesArr = file_get_contents("../devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    
    $typeLength = 0;
    $clrRgeLen = 0;
    $touchLen = 0;
    $sizeLen = 0;
    $resLen = 0;
    $ratioLen = 0;


    include '../dbhandler.php';

    foreach ($devicesDecode as $key => $jsons) { // This will search in the 2 jsons

        foreach($jsons as $key => $spec) {

            if ($key === '_screen') {
                foreach ($spec as $scrKey=>$scrSpec) {
                    switch ($scrKey) {
                        case 'type':
                            $scrType = $scrSpec;
                            // if (strlen($scrSpec) > $typeLength) {
                            //     $typeLength = strlen($scrSpec);
                            // }
                            break;

                        case 'colorRge':
                            $scrColRge = $scrSpec;
                            // if (strlen($scrSpec) > $clrRgeLen) {
                            //     $clrRgeLen = strlen($scrSpec);
                            // }
                            break;

                        case 'touchscreen':
                            $touchScreen = $scrSpec;
                            // if (strlen($scrSpec) > $touchLen) {
                            //     $touchLen = strlen($scrSpec);
                            // }
                            break;

                        case 'size':
                            $scrSize = $scrSpec;
                            // if (strlen($scrSpec) > $sizeLen) {
                            //     $sizeLen = strlen($scrSpec);
                            // }
                            break;

                        case 'res':
                            $scrRes = $scrSpec;
                            // if (strlen($scrSpec) > $resLen) {
                            //     $resLen = strlen($scrSpec);
                            // }
                            break;

                        case 'ratio':
                            $scrRatio = $scrSpec;
                            // if (strlen($scrSpec) > $ratioLen) {
                            //     $ratioLen = strlen($scrSpec);
                            // }
                            break;
                    }
                }
            }
        }


        $sql = "INSERT INTO scr_specs (scr_type, clr_rge, touch_scr, scr_size, scr_res, scr_ratio)
                VALUES ('$scrType', '$scrColRge', '$touchScreen', $scrSize,  '$scrRes', '$scrRatio')";

        $conn->query($sql);
        echo mysqli_error($conn);
   }

//    echo 'Type string is ' . $typeLength . ' characters', "\n";
//    echo 'ColorRange string is ' . $clrRgeLen . ' characters', "\n";
//    echo 'Touchscreen string is ' . $touchLen . ' characters', "\n";
//    echo 'ScreenSize string is ' . $sizeLen . ' characters', "\n";
//    echo 'ScrRes string is ' . $resLen . ' characters', "\n";
//    echo 'ScrRatio string is ' .  $ratioLen . ' characters', "\n";

    $conn->close();
?>