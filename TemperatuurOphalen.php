<?php

include __DIR__ . "/header.php";
$conn = connectToDatabase();

ini_set('max_execution_time', '300000');
set_time_limit(300000);


function temperatuurOphalen()
{
    while (true) {
        $temperatuur = file_get_contents("http://127.0.0.1:5000");
        return $temperatuur;
    }
}


//while (true) {
//    $temp = temperatuurOphalen();
//
//    $naarArchiefColdRoomTemperatureIDQuery = mysqli_query($conn, "SELECT ColdRoomTemperatureID FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 5");
//    $naarArchiefColdRoomTemperatureID = mysqli_fetch_array($naarArchiefColdRoomTemperatureIDQuery);
//
//    $naarArchiefColdRoomSensorNumberQuery = mysqli_query($conn, "SELECT ColdRoomSensorNumber FROM coldroomtemperatures WHERE ColdRoomTemperatureID = '$naarArchiefColdRoomTemperatureID[0]'");
//    $naarArchiefColdRoomSensorNumber = mysqli_fetch_array($naarArchiefColdRoomSensorNumberQuery);
//
//    $naarArchiefColdRoomRecordedWhenQuery = mysqli_query($conn, "SELECT RecordedWhen FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 5");
//    $naarArchiefColdRoomRecordedWhen = mysqli_fetch_array($naarArchiefColdRoomRecordedWhenQuery);
//
//    $naarArchiefColdRoomTemperatureQuery = mysqli_query($conn, "SELECT Temperature FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 5");
//    $naarArchiefColdRoomTemperature = mysqli_fetch_array($naarArchiefColdRoomTemperatureQuery);
//
//    $naarArchiefColdRoomValidFromQuery = mysqli_query($conn, "SELECT ColdRoomTemperatureID FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 5");
//    $naarArchiefColdRoomValidFrom = mysqli_fetch_array($naarArchiefColdRoomValidFromQuery);
//
//
//    mysqli_query($conn, "INSERT INTO coldroomtemperatures_archive (ColdRoomTemperatureID, ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo)
//VALUES ('$naarArchiefColdRoomTemperatureID[0]', '$naarArchiefColdRoomSensorNumber[0]', '$naarArchiefColdRoomRecordedWhen[0]', '$naarArchiefColdRoomTemperature[0]', '$naarArchiefColdRoomValidFrom[0]', NOW())");
//
//    mysqli_query($conn, "DELETE FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 5");
//
//    mysqli_query($conn, "insert into coldroomtemperatures (ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo)
//VALUES (5, NOW(), '$temp', NOW(), '9999-12-31 23:59:59')");
//    sleep(3);
//}
