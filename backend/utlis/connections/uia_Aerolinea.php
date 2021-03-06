<?php

require_once("../../utlis/adodb5/adodb.inc.php");

/*
  Inicializacion de la conexion
  Desarrollo o produccion
 */

global $config_AMBIENTE_BD;

switch ($config_AMBIENTE_BD) {
    case "desarrollo":
        $driver = 'mysqli';
        $labAdodb = newAdoConnection($driver);
        $labAdodb->setCharset('utf8');
        $labAdodb->setConnectionParameter('CharacterSet', 'WE8ISO8859P15');
        $labAdodb->Connect("127.0.0.1", "root", "bases1", "progra3");
       
        break;
    case "produccion":
        $driver = 'mysqli';
        $labAdodb = newAdoConnection($driver);
        $labAdodb->setCharset('utf8');
        $labAdodb->setConnectionParameter('CharacterSet', 'WE8ISO8859P15');
        $labAdodb->Connect("prd", "user_prd", "user_pass", "database");
        break;
}
	
