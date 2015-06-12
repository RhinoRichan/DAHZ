<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; 
}

/**
* Global Option Customizer 
* Get theme’s settings from database with df_options('theme_settings').
* @see Dahz_Customizer_Options::getOptionSetting()
* @param array $name
* @return mixed
*/
function df_options($name) {
	$options = new Dahz_Customizer_Options();
  	return $options::getOptionSetting($name);
}

/**
* Returns a boolean on the customizer's state
* @see Dahz_Customizer_Options::isCustomizerPreview()
* @return boolean
*/
function df_is_customizing() {
	$preview = new Dahz_Customizer_Options();
	return $preview::isCustomizerPreview();
}