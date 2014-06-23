<?php

/*
* Plugin Name: EDD Tax Exluder
* Plugin Author: Nick Haskins
*
*
*/
add_filter( 'edd_get_cart_tax', 	'ase_edd_exclude_taxes');
add_filter( 'edd_settings_tabs', 	'ase_edd_exclude_taxes_tab' );
add_action( 'admin_init', 			'ase_edd_exclude_taxes_settings');

function ase_edd_exclude_taxes(){

	global $edd_options;

	$get_id = isset($edd_options['ase_excluded_tax_accounts']) ? $edd_options['ase_excluded_tax_accounts'] : false;
	$id = array_map('intval', explode(',', $get_id));

	if ( get_current_user_id() == $id || ( is_array($id) && in_array( get_current_user_id(), $id ) )) {
		return '0';
	} else {
		return true;
	}
}

function ase_edd_exclude_taxes_tab( $tabs ) {

	$ns = 'ase-edd-exclude-taxes';

    $tabs[$ns] = 'ASE Exclude Tax';

    return $tabs;
}

function ase_edd_exclude_taxes_settings() {

	$ns = 'ase-edd-exclude-taxes';

    add_settings_section(
        'edd_settings_'.$ns,
        __return_null(),
        '__return_false',
        'edd_settings_'.$ns
    );

    add_settings_field(
        'edd_settings[ase_excluded_tax_accounts]',
        'User IDs to Exclude from Tax',
        'edd_text_callback',
        'edd_settings_'.$ns,
        'edd_settings_'.$ns,
        array(
            'id'      => 'ase_excluded_tax_accounts',
            'desc'    => 'List of comma separated user id\'s that should be excluded from having tax applied.',
            'name'    => 'User Ids to Exclude from Tax',
            'section' => $ns
        )
    );

}
