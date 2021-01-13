<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

class CrbSocials {
	const NETWORKS = array(
		'facebook' => array(
			'label' => 'Facebook',
			'icon'  => 'fab fa-facebook-square',
		),
		'twitter' => array(
			'label' => 'Twitter',
			'icon'  => 'fab fa-twitter-square',
		),
		'instagram' => array(
			'label' => 'Instagram',
			'icon'  => 'fab fa-instagram',
		),
		'pinterest' => array(
			'label' => 'Pinterest',
			'icon'  => 'fab fa-pinterest-square',
		),
		'youtube' => array(
			'label' => 'YouTube',
			'icon'  => 'fab fa-youtube-square',
		)
	);

	static function set_fields() {
		$fields = array();

		foreach ( self::NETWORKS as $network => $data ) {
			$fields[] = Field::make( 'text', 'crb_' . $network, $data['label'] );
		}

		return $fields;
	}

	static function get_fields() {
		$fields = array();

		foreach ( self::NETWORKS as $network => $data ) {
			$link = carbon_get_theme_option( 'crb_' . $network );

			if ( ! $link ) {
				continue;
			}

			$fields[ $network ] = array(
				'label' => $data['label'],
				'icon'  => $data['icon'],
				'link'  => $link,
			);
		}

		return $fields;
	}
}
