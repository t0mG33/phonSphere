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

    echo 'Success: A proper connection to MySQL was made.';

    foreach ($devicesDecode as $key => $jsons) { // This will search in the 2 jsons

        foreach($jsons as $key => $spec) {

            switch ($key) {
                case '_name':
                    $devName = $spec;
                    break;
                
                case '_brand':
                    $devBrand = $spec;
                    break;
                
                case '_dims':
                    foreach ($spec as $dimsKey=>$dims) {
                        switch ($dimsKey) {
                            case 'height':
                                // echo $dims;
                                // echo gettype($dims), "\n";
                                $devHeight = $dims;
                                break;

                            case 'width':
                                $devWidth = $dims;
                                break;

                            case 'depth':
                                $devDepth = $dims;
                                break;
                        }
                    }
                    break;

                case '_weight':
                    $devWeight = $spec;
                    break;

                case '_isWaterProof':
                    if ($spec === 0 || $spec === '' || $spec === false) {
                        $devIsWaterproof = 0;
                    } else {
                        $devIsWaterproof = 1;
                    }
                    break;
            }
        }

        $sql = "INSERT INTO devices (name, brand, height, width, depth, weight, is_waterproof)
                VALUES ('$devName', '$devBrand', $devHeight, $devWidth, $devDepth, $devWeight, $devIsWaterproof)";

        $mysqli->query($sql);
        echo mysqli_error($mysqli);
   }

    $mysqli->close();
?>