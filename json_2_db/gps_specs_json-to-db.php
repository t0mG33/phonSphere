<?php 
    
    $JSONdevicesArr = file_get_contents("../devices.json");
    $devicesDecode = json_decode($JSONdevicesArr, TRUE);

    // $gpsSys  = array();


    include '../dbhandler.php';

    foreach ($devicesDecode as $key => $jsons) { // This will search in the 2 jsons

        foreach($jsons as $key => $spec) {

            // if ($key === '_gps') {
            //     // $gpsSys  = array();
            //     foreach ($spec as $gps) {
            //         if (in_array($gps, $gpsSys) === false) {
            //             array_push($gpsSys,$gps);
            //         }
            //         // echo count($gpsSys),"\n";
            //     }
                
            // }

            if ($key === '_gps') {

                $has_AGPS = 0;
                $has_GLONASS = 0;
                $has_GALILEO = 0;
                $has_QZSS = 0;
                $has_BDS = 0;
                $has_BDS2 = 0;
                $has_SBAS = 0;

                foreach ($spec as $gps) {
                    switch ($gps) {
                        case 'A-GPS':
                            global $has_AGPS;
                            $has_AGPS = 1;
                            break;

                        case 'GLONASS':
                            global $has_GLONASS;
                            $has_GLONASS = 1;
                            break;

                        case 'GALILEO':
                            global $has_GALILEO;
                            $has_GALILEO = 1;
                            break;

                        case 'QZSS':
                            global $has_QZSS;
                            $has_QZSS = 1;
                            break;

                        case 'BDS':
                            global $has_BDS;
                            $has_BDS = 1;
                            break;

                        case 'BDS2':
                            global $has_BDS2;
                            $has_BDS2 = 1;
                            break;

                        case 'SBAS':        
                            global $has_SBAS;
                            $has_SBAS = 1;
                            break;
                    }
                }
            }
        }

        // echo $has_AGPS, "\n";
        // echo $has_GLONASS, "\n";
        // echo $has_GALILEO, "\n";
        // echo $has_QZSS, "\n";
        // echo $has_BDS, "\n";
        // echo $has_BDS2, "\n";
        // echo $has_SBAS, "\n";


        $sql = "INSERT INTO gps_specs (has_a_gps, has_glonass, has_galileo, has_qzss, has_bds, has_bds2, has_sbas)
                VALUES ($has_AGPS, $has_GLONASS, $has_GALILEO, $has_QZSS, $has_BDS, $has_BDS2, $has_SBAS)";

        $conn->query($sql);
        echo mysqli_error($conn);
   }

    $conn->close();
?>