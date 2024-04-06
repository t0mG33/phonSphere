<?php 
    
    $JSONdevicesArr = file_get_contents("../devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    // $length = 0;

    include '../dbhandler.php';

    foreach ($devicesDecode as $key => $jsons) { // This will search in the 2 jsons

        foreach($jsons as $key => $spec) {

            if ($key === '_OS') {
                foreach ($spec as $OSKey=>$os) {
                    switch ($OSKey) {
                        case 'name':
                            $devOS = $os;
                            // if (strlen($os) > $length) {
                            //     $length = strlen($os);
                            // }
                            break;

                        case 'version':
                            $devWOSName = $os;
                            break;

                        case 'upgrade':
                            if ($os === false || $os === null) {
                                $devOSUpgrade = 'none';
                            } else {
                                $devOSUpgrade = $os;
                                
                            }
                            break;
                    }
                }
            }
        }

        $sql = "INSERT INTO os_specs (opSys, opSys_version, opSys_upgrade)
                VALUES ('$devOS', '$devWOSName', '$devOSUpgrade')";

        $conn->query($sql);
        echo mysqli_error($conn);
   }

//    echo $length;

    $conn->close();
?>