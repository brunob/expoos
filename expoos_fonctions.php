<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// restreindre les champs extras en fonction de la composition de la rubrique
include_spip('inc/cextras_autoriser');
restreindre_extras('rubrique', ['largeur','variante','colonnes','carto'], 'expo', 'composition');