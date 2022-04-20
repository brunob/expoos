<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS['z_blocs'] = array(
	'content',
	'head',
	'head_js',
	'header',
	'footer'
);

// désactiver l'héritage des logos de rubriques
define('_LOGO_RUBRIQUE_DESACTIVER_HERITAGE', true);

// indiquer à offline de cacher les fichiers audio présents dans les pages
define('_OFFLINE_RESSOURCES_TAGS', ['audio' => 'src', 'object' => 'data']);

$GLOBALS['gis_layers']['geoportail'] = [
	'nom' => 'Geoportail IGN',
	'layer' => 'L.tileLayer(
		"https://wxs.ign.fr/decouverte/geoportail/wmts?&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0&STYLE=normal&TILEMATRIXSET=PM&FORMAT=image/jpeg&LAYER=ORTHOIMAGERY.ORTHOPHOTOS&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}",
		{
			maxNativeZoom: 19,
			maxZoom: 21,
			attribution : "<a href=\'https://www.ign.fr/\'>IGN</a>"
		}
	)'
];

$GLOBALS['gis_layers']['brgm'] = [
	'nom' => 'BRGM',
	'layer' => 'L.tileLayer.wms("https://geoservices.brgm.fr/WMS-C/", {
		layers: "SCAN_F_GEOL250",
		format: "png",
		transparent: true,
		attribution: "<a href=\'http://infoterre.brgm.fr/geoservices-ogc\'>BRGM</a>",
		crs: L.CRS.EPSG4326,
		bounds: L.latLngBounds([41.9671,-6.20495], [51.2917,12.2874]),
		minZoom: 6,
		maxZoom: 15
	})'
];
