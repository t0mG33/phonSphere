<?php 
    
    $JSONdevicesArr = file_get_contents("../devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    
    include '../dbhandler.php';

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

        $conn->query($sql);
        echo mysqli_error($conn);
   }

    $conn->close();
?>