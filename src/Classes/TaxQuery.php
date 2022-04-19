<?php

namespace MYND\WPQ\Classes;

class TaxQuery extends SubQuery {

	private $taxonomy;
	private $terms;
	private $field = 'term_id';
	private $operator = 'IN';

	const SEARCH_BY_SLUG = 'slug';
	const SEARCH_BY_NAME = 'name';
	const SEARCH_BY_TERM_TAX_ID = 'term_taxonomy_id';
	const SEARCH_BY_ID = 'term_id';

	public function __construct( $taxonomy, $terms = [] ) {
		$this->taxonomy = $taxonomy;
		$this->terms    = $terms;
	}

	public function terms( $terms ) {
		$this->terms = $terms;

		return $this;
	}

	public function areAssigned() {
		$this->operator = 'IN';

		return $this;
	}

	public function areNotAssigned() {
		$this->operator = 'NOT IN';

		return $this;
	}

	public function searchBy( $field ) {

		$allowed = [ self::SEARCH_BY_ID, self::SEARCH_BY_NAME, self::SEARCH_BY_TERM_TAX_ID, self::SEARCH_BY_SLUG ];

		if ( ! in_array( $field, $allowed ) ) {
			throw new \Exception( 'Invalid tax field type supplied: ' . $field );
		}

		$this->field = $field;

		return $this;
	}

	public function get() {
		return [
			'taxonomy' => $this->taxonomy,
			'field'    => $this->field,
			'terms'    => $this->terms,
			'operator' => $this->operator,
		];
	}

	public static function getKey() {
		return 'tax_query';
	}
}