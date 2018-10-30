<?php  /// Moodle Configuration File 

unset($CFG);

$CFG = new stdClass();
$CFG->dbtype    = 'mysql';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'db_spbniif_2';
$CFG->dbuser    = 'dbu_spbniif_1';
$CFG->dbpass    = 'nFxYQ2jb3dm';
$CFG->dbpersist =  false;
$CFG->prefix    = 'mdl_';

$CFG->wwwroot   = 'http://eduspbniif4.local';
$CFG->dirroot   = 'C:/Users/am.paivina/Downloads/OSPanel/domains/eduspbniif4.local';
$CFG->dataroot  = 'C:/Users/am.paivina/Downloads/OSPanel/domains/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode

$CFG->passwordsaltmain = 'E?.D+MYVu-+<6c`-rOFzPiQyjheaY';

require_once("$CFG->dirroot/lib/setup.php");
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>