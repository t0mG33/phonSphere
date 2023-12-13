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

            if ($key === '_devBattery') {
                
                foreach ($spec as $battKey=>$connSpec) {

                    $fastCharg = 0;

                    switch ($battKey) {
                        case 'technology':
                            $tech = $connSpec;
                            break;

                        case 'mAhCapacity':
                            $mAhCap = $connSpec;
                            break;

                        case 'whCapacity':
                            if ($connSpec != false ||  $connSpec != null || $connSpec != '') {
                                $wHcap = $connSpec;
                            }
                            break;

                        case 'fastCharging':
                            $fastCharg = $connSpec;
                            break;
                    }
                }
            }
        }

        $sql = "INSERT INTO battery_specs (tech, mAh_cap, wh_cap, fast_charg)
                VALUES ('$tech', $mAhCap, $wHcap, $fastCharg)";

        $mysqli->query($sql);
        echo mysqli_error($mysqli);
   }

    $mysqli->close();
?>