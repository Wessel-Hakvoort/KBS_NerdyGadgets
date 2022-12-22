# KBS_NerdyGadgets

Alleen view.php is aangepast!!
#raspberrypi----------------------------------------------------

CREATE TABLE IF NOT EXISTS `sensor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  `eenheid` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO sensor
VALUES (5, 'Temperatuur', 'C');

#Checken database:
select ColdRoomTemperatureID, ColdRoomSensorNumber, Temperature, ValidTo
from coldroomtemperatures_archive 
where ColdRoomSensorNumber;

#alles wordt nu nog geselecteerd uit coldroomtemperatures_archive ipv coldroomtemperatures, omdat het nog niet live is
#Deleten oude records zodat het niet super lang duurt met producten laden (zijn nog 100 duizenden oude records, wat het wat slomer maakt) Ik heb zelf 90 (0,9) procent van oude records weggedaan, in stapjes van 0,3 (30%) :

delete from coldroomtemperatures_archive where rand() < 0.4; (0,1-0,9 -> 10%-90%)
