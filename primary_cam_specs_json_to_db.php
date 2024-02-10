<?php 
    
    $JSONdevicesArr = file_get_contents("devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);

    include 'dbhandler.php';
    
    if ($mysqli->connect_error) {
        echo 'Errno: '.$mysqli->connect_errno;
        echo '<br>';
        echo 'Error: '.$mysqli->connect_error;
        exit();
    }

    echo 'Success: A proper connection to MySQL was made.', "\n";

    foreach ($devicesDecode as $key => $jsons) { // This will search in the 2 jsons

        foreach($jsons as $key => $spec) {

            if ($key === '_mainCamFeats') {
                // echo "Foo", "\n";
                foreach ($spec as $camKey=>$camSpec) {
                    switch ($camKey) {
                        case 'camRes':
                            $camRes= $camSpec;
                            break;

                        case 'camExp':
                            foreach ($camSpec as $camExpKey=>$camExpSpec) {
                                // echo $camExpKey,"\n";
                                // echo $camExpSpec, "\n";
                                switch ($camExpKey) {
                                    case "ape":
                                        // echo "BaR", "\n";
                                        if ($camExpSpec === null) {
                                            $camApe = 0;
                                        } else {
                                            $camApe = $camExpSpec;
                                        }
                                        break;
                                    
                                    case 'lenseWidth':
                                        if ($camExpSpec === null) {
                                            $camLenseWidth = 0;
                                        } else {
                                            $camLenseWidth = $camExpSpec;
                                        }
                                        break;
                                }
                            }
                            break;

                        case 'ois':
                            if ($camSpec === false || $camSpec === null) {
                                $has_Ois = 0;
                            } else {
                                $has_Ois = 1;
                            }
                            break;

                        case 'opticalZoom':
                            if (is_int($camSpec) != 1) {
                                $opticZoom = 0;
                            } else {
                                $opticZoom = $camSpec;
                            }
                            break;
                        
                        case 'dualCam':
                            if ($camSpec === false) {
                                $has_dualCam = 0;
                            } else {
                                $has_dualCam = 1;
                            }
                            break;

                        case 'video':
                            foreach ($camSpec as $camVdoKey=>$camVdoSpec) {
                                switch ( $camVdoKey) {
                                    case "reso":
                                        if ($camVdoSpec === null || is_int($camVdoSpec) != 1) {
                                            $camVdoRes = 0;
                                        } else {
                                            $camVdoRes = $camVdoSpec;
                                        }
                                        break;
                                    
                                    case 'uhd4K':
                                        if ($camVdoSpec == false) {
                                            $has_UHD4K = 0;
                                        } else {
                                            $has_UHD4K = 1;
                                        }
                                        
                                        break;
                                }
                            }
                            break;

                        case 'hdr':
                            if ($camSpec === false || $camSpec === null) {
                                $has_HDR = 0;
                            } else {
                                $has_HDR = 1;
                            }
                            break;
                    }
                }
            }
        }

        // echo $camRes, "\n";
        // echo $camApe, "\n";
        // echo $camLenseWidth, "\n";
        // echo $has_Ois, "\n";
        // echo $opticZoom, "\n";
        // echo $has_dualCam, "\n";
        // echo $camVdoRes, "\n";
        // echo $has_UHD4K, "\n";
        // echo $has_HDR, "\n";

        if (!isset($has_dualCam )) {
            $has_dualCam = 0;
        }

        if (!isset($camVdoRes)) {
            $camVdoRes = 0;
        }

        if (!isset($has_Ois)) {
            $has_Ois = 0;
        }

        if (!isset($opticZoom)) {
            $opticZoom = 0;
        }

        if (!isset($camApe)) {
            $camApe = 0;
        }

        if (!isset($camLenseWidth)) {
            $camLenseWidth = 0;
        }

        if (!isset($has_UHD4K)) {
            $has_UHD4K = 0;
        }

        if (!isset($has_HDR)) {
            $has_HDR = 0;
        }

        $sql = "INSERT INTO primary_cam_specs (camRes, lensApe, lensWidth, OIS, opticZoom, dualCam, videoRes, uhd4k, hdr)
            VALUES ($camRes, $camApe, $camLenseWidth, $has_Ois, $opticZoom, $has_dualCam, $camVdoRes, $has_UHD4K, $has_HDR)";

        $mysqli->query($sql);
        echo mysqli_error($mysqli);
   }

    $mysqli->close();
?>