<?php
$kasutaja = 'saiko_tarpv21'; //d113372_denis /saiko_tarpv21
$server = 'localhost'; //d113372.mysql.zonevs.eu /localhost
$andmebaas = 'tarpv21'; //d113372_baasdenis /tarpv21
$salasyna='123456';
//teeme käsk mis ühendab andmebaasiga
$yhendus = new mysqli($server,$kasutaja,$salasyna,$andmebaas);
$yhendus -> set_charset('UTF8');
/*
CREATE TABLE loomad(
    id int PRIMARY KEY AUTO_INCREMENT,
    loomaNimi varchar(15) UNIQUE,
    vanus int,
    pilt text)
*/
?>
