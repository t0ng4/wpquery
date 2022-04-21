<?php

namespace MYND\WPQ\Classes;

use MYND\WPQ\Exceptions\QueryException;

class PostQuery {

	private $arguments;
	private $query = null;

	public function getQuery() {
		return $this->query;
	}

	public function with( ...$arguments ) {
		foreach ( $arguments as $argument ) {

			if ( is_array( $argument ) && sizeof( $argument ) > 0 ) {
				$class                                       = get_class( $argument[0] );
				$subQueryKey                                 = ( "{$class}::getKey" )();
				$this->arguments[ $subQueryKey ]['relation'] = 'AND';
				foreach ( $argument as $queryInstance ) {
					$this->arguments[ $subQueryKey ][] = $queryInstance->get();
				}
			} else {
				$class                                       = get_class( $argument );
				$subQueryKey                                 = ( "{$class}::getKey" )();
				$this->arguments[ $subQueryKey ]['relation'] = 'OR';
				$this->arguments[ $subQueryKey ][]           = $argument->get();
			}
		}

		return $this;
	}

	public function type( array $types ) {
		$this->arguments['post_type'] = $types;

		return $this;
	}

	public function status( array $status ) {
		$this->arguments['post_status'] = $status;

		return $this;
	}

	public function author( $author ) {
		$this->arguments['author'] = $author;

		return $this;
	}

	public function get() {
		global $wpdb;

		$q           = new \WP_Query( $this->arguments );
		$this->query = $q->request;

		return $q->get_posts();

	}

}