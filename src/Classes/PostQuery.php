<?php

namespace MYND\WPQ\Classes;

use MYND\WPQ\Exceptions\QueryException;

class PostQuery {

	private $arguments;
	private $query;

	public function getQuery() {
		return $this->query;
	}

	public function withDate( array $dateQueries ) {

		foreach ( $dateQueries as $dateQuery ) {
			$this->arguments['date_query'][] = $dateQuery->get();
		}

		return $this;
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

	private function isArrayOf( $array, $class ) {

	}

	public function ofType( array $types ) {
		$this->arguments['post_type'] = $types;

		return $this;
	}

	public function hasStatus( array $status ) {
		$this->arguments['post_status'] = $status;

		return $this;
	}

	public function withAnyTaxonomy( $taxQueries ) {

		$this->arguments['tax_query']['relation'] = 'OR';
		foreach ( $taxQueries as $taxQuery ) {
			$this->arguments['tax_query'][] = $taxQuery->get();
		}

		return $this;
	}

	public function withAllTaxonomies( $taxQueries ) {

		$this->arguments['tax_query']['relation'] = 'AND';
		foreach ( $taxQueries as $taxQuery ) {
			$this->arguments['tax_query'][] = $taxQuery->get();
		}

		return $this;
	}

	private function typeOfMeta( $metaQueries, $relation ) {

		if ( ! is_array( $metaQueries ) ) {
			throw new QueryException( 'metaQuery parameter must be of type array.' );
		}

		$this->arguments['meta_query']['relation'] = $relation;
		foreach ( $metaQueries as $metaQuery ) {
			$this->arguments['meta_query'][] = $metaQuery->get();
		}
	}

	public function withAllOfMeta( $metaQueries ) {
		$this->typeOfMeta( $metaQueries, 'AND' );

		return $this;
	}

	public function withAnyOfMeta( $metaQueries ) {
		$this->typeOfMeta( $metaQueries, 'OR' );

		return $this;
	}

	public function createdBy( $author ) {
		$this->arguments['post_author'] = $author;

		return $this;
	}

	public function get() {
		global $wpdb;

		$q           = new \WP_Query( $this->arguments );
		$this->query = $q->request;

		return $q->get_posts();

	}

}