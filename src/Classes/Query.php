<?php

namespace MYND\WPQ\Classes;

use MYND\WPQ\Classes\PostQuery;
use MYND\WPQ\Classes\TaxQuery;
use MYND\WPQ\Classes\MetaQuery;

class Query {

	public static function post() {
		return new PostQuery();
	}

	public static function date() {
		return new DateQuery();
	}

	public static function postmeta( $key ) {
		return new MetaQuery( $key );
	}

	public static function taxonomy( $taxonomy, $terms = [] ) {
		return new TaxQuery( $taxonomy, $terms );
	}

}