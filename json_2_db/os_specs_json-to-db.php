<?php 
    
    $JSONdevicesArr = file_get_contents("devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);
    // $length = 0;

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

        $mysqli->query($sql);
        echo mysqli_error($mysqli);
   }

//    echo $length;

    $mysqli->close();
?>