<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS['z_blocs'] = array(
	'content',
	'extra',
	'head',
	'head_js',
	'header',
	'footer'
);

// désactiver l'héritage des logos de rubriques
define('_LOGO_RUBRIQUE_DESACTIVER_HERITAGE', true);
