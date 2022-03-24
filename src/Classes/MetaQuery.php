<?php

namespace MYND\WPQ\Classes;

class MetaQuery {

	private $key;
	private $value;
	private $compare = 'LIKE';
	private $type = 'char';

	const COMPARE_EQUAL = '=';
	const COMPARE_NOT_EQUAL = '!=';
	const COMPARE_GREATER = '>';
	const COMPARE_GREATER_EQUAL = '>=';
	const COMPARE_LESS = '<';
	const COMPARE_LESS_EQUAL = '<=';
	const COMPARE_LIKE = 'LIKE';
	const COMPARE_NOT_LIKE = 'NOT LIKE';
	const COMPARE_IN = 'IN';
	const COMPARE_NOT_IN = 'NOT IN';
	const COMPARE_BETWEEN = 'BETWEEN';
	const COMPARE_NOT_BETWEEN = 'NOT BETWEEN';
	const COMPARE_EXISTS = 'EXISTS';
	const COMPARE_NOT_EXISTS = 'NOT EXISTS';
	const COMPARE_REGEXP = 'REGEXP';
	const COMPARE_NOT_REGEXP = 'NOT REGEXP';
	const COMPARE_RLIKE = 'RLIKE';

	const TYPE_NUMERIC = 'NUMERIC';
	const TYPE_BINARY = 'BINARY';
	const TYPE_CHAR = 'CHAR';
	const TYPE_DATE = 'DATE';
	const TYPE_DATETIME = 'DATETIME';
	const TYPE_DECIMAL = 'DECIMAL';
	const TYPE_SIGNED = 'SIGNED';
	const TYPE_TIME = 'TIME';
	const TYPE_UNSIGNED = 'UNSIGNED';

	public function __construct( $key, $value = null ) {
		$this->key   = $key;
		$this->value = $value;
	}

	public function greater( $value ) {
		$this->compare = self::COMPARE_GREATER;
		$this->type    = self::TYPE_NUMERIC;
		$this->value   = $value;

		return $this;
	}

	public function greaterEqual( $value ) {
		$this->compare = self::COMPARE_GREATER_EQUAL;
		$this->type    = self::TYPE_NUMERIC;
		$this->value   = $value;

		return $this;
	}

	public function less( $value ) {
		$this->compare = self::COMPARE_LESS;
		$this->type    = self::TYPE_NUMERIC;
		$this->value   = $value;

		return $this;
	}

	public function lessEqual( $value ) {
		$this->compare = self::COMPARE_LESS_EQUAL;
		$this->type    = self::TYPE_NUMERIC;
		$this->value   = $value;

		return $this;
	}

	public function is( $value ) {
		$this->compare = self::COMPARE_EQUAL;
		$this->type    = self::TYPE_CHAR;
		$this->value   = $value;

		return $this;
	}

	public function isNot( $value ) {
		$this->compare = self::COMPARE_NOT_EQUAL;
		$this->type    = self::TYPE_CHAR;
		$this->value   = $value;

		return $this;
	}

	public function between( $lowerBoundary, $upperBoundary ) {
		$this->compare  = self::COMPARE_BETWEEN;
		$this->type     = self::TYPE_NUMERIC;
		$this->value[0] = $lowerBoundary;
		$this->value[1] = $upperBoundary;

		return $this;
	}

	public function notBetween( $lowerBoundary, $upperBoundary ) {
		$this->compare  = self::COMPARE_NOT_BETWEEN;
		$this->type     = self::TYPE_NUMERIC;
		$this->value[0] = $lowerBoundary;
		$this->value[1] = $upperBoundary;

		return $this;
	}

	public function like( $value ) {
		$this->compare = self::COMPARE_LIKE;
		$this->type    = self::TYPE_CHAR;
		$this->value   = $value;

		return $this;
	}

	public function notLike( $value ) {
		$this->compare = self::COMPARE_NOT_LIKE;
		$this->type    = self::TYPE_CHAR;
		$this->value   = $value;

		return $this;
	}

	public function in( $value ) {
		$this->compare = self::COMPARE_IN;
		$this->type    = self::TYPE_CHAR;
		$this->value   = $value;

		return $this;
	}

	public function notIn( $value ) {
		$this->compare = self::COMPARE_NOT_IN;
		$this->type    = self::TYPE_CHAR;
		$this->value   = $value;

		return $this;
	}

	public function exists() {
		$this->compare = self::COMPARE_EXISTS;
		$this->type    = self::TYPE_CHAR;
		$this->value   = null;

		return $this;
	}

	public function notExists() {
		$this->compare = self::COMPARE_NOT_EXISTS;
		$this->type    = self::TYPE_CHAR;
		$this->value   = null;

		return $this;
	}

	public function get() {

		$config = [
			'key'     => $this->key,
			'value'   => $this->value,
			'compare' => $this->compare,
			'type'    => $this->type,
		];

		if ( null === $this->value ) {
			unset( $config['value'] );
		}

		return $config;
	}


}