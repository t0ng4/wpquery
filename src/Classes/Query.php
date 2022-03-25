<?php

namespace MYND\WPQ\Classes;

class Query {

	public static function post() {
		return new PostQuery();
	}

	public static function postmeta( $value ) {
		return new MetaQuery( $value );
	}

}