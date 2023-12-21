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

            if ($key === '_devCPU') {
                foreach ($spec as $coreKey=>$coreSpec) {
                    switch ($coreKey) {
                        case 'techno':
                            $cpuTech= $coreSpec;
                            break;

                        case 'power':
                            $cpuPwr = $coreSpec;
                            break;
                    }
                }
            }
            elseif ($key === '_ram') {
                if (gettype($spec) === 'integer') {
                    $ram = number_format((float)$spec, 1, '.', '');
                } else {
                    $ram = $spec;
                }
            }
            elseif ($key === '_storage') {

                foreach ($spec as $storageKey=>$storageSpec) {
                    switch ($storageKey) {
                        case 'builtIn':
                            $storageCount = count($storageSpec);
                            for ($i=0; $i<$storageCount; $i++) {
                                if ($i === 0) {
                                    $minBuiltinStorage = $storageSpec[$i];
                                }
                                if ($i === $storageCount - 1) {
                                    $maxBuiltinStorage = $storageSpec[$i];
                                }
                            }
                            break;

                        case 'ext':
                            if ($storageSpec === 0 || $storageSpec === '' || $storageSpec === false) {
                                $extStrCap = 0;
                                $extStrFormat = 'N.A';
                            } else {

                                $ext_storage_format_count = count($storageSpec);

                                for ($i=0; $i<$ext_storage_format_count; $i++) {
                                    if ($i === 0) {
                                        $extStrCap = $storageSpec[$i];
                                    }
                                    else {
                                        if (strlen($storageSpec[$i]) > 0) {
                                            $extStrFormat = $storageSpec[$i];
                                        } else {
                                            $extStrFormat = 'Unknown';
                                        }
                                    }
                                }
                                
                            }
                            break;
                    }
                }
            }
        }

        $sql = "INSERT INTO core_specs (cpu_specs, cpu_power, ram, min_builtIn_str, max_builtIn_str, ext_str_cap, ext_str_form)
            VALUES ('$cpuTech', '$cpuPwr', $ram, $minBuiltinStorage, $maxBuiltinStorage, $extStrCap, '$extStrFormat')";

        $mysqli->query($sql);
        echo mysqli_error($mysqli);
   }

    $mysqli->close();
?>