<?php

namespace MYND\WPQ\Classes;

use MYND\WPQ\Exceptions\QueryException;

class DateQuery extends SubQuery {

	private $year;
	private $month;
	private $day;
	private $hour;
	private $minute;
	private $second;

	private $column = 'post_date';
	private $compare = '>';
	private $after = null;
	private $before = null;

	private $inclusive = true;

	const POST_CREATED = 'post_date';
	const POST_MODIFIED = 'post_modified';

	const ALLOWED_KEYS = [ 'year', 'month', 'day', 'hour', 'minute', 'second' ];

	public function __construct( $year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null ) {
		$this->year   = $year;
		$this->month  = $month;
		$this->day    = $day;
		$this->hour   = $hour;
		$this->minute = $minute;
		$this->second = $second;
	}

	public function created() {
		$this->column = self::POST_CREATED;

		return $this;
	}

	public function modified() {
		$this->column = self::POST_MODIFIED;

		return $this;
	}

	private function validateDateArray( array $date ) {
		foreach ( $date as $key => $part ) {
			if ( ! in_array( $key, self::ALLOWED_KEYS ) ) {
				throw new QueryException( 'Invalid key ' . $key . ' element supplied.' );
			}
			$this->$key = $part;
		}

		return true;
	}

	private function applyDateArray( array $date ) {
		foreach ( $date as $key => $part ) {
			$this->$key = $part;
		}
	}

	public function within( $date, $extract = 'Ymdhis' ) {

		if ( is_array( $date ) && $this->validateDateArray( $date ) ) {
			$this->applyDateArray( $date );
		} else {
			$parts = $this->extractFromDate( $date, $extract );
			$this->applyDateArray( $parts );
		}

		return $this;
	}

	public function inclusive() {

		$this->inclusive = true;

		return $this;
	}

	public function exclusive() {

		$this->inclusive = false;

		return $this;
	}

	public function between( $fromDate, $toDate ) {

		$this->after  = $this->extractFromDate( $fromDate );
		$this->before = $this->extractFromDate( $toDate );

		return $this;
	}

	public function before( $beforeDate ) {
		$this->before = $this->extractFromDate( $beforeDate );

		return $this;
	}

	public function after( $afterDate ) {
		$this->after = $this->extractFromDate( $afterDate );

		return $this;
	}

	public function extractFromDate( $date, $extract = 'Ymdhis' ) {

		if ( ! is_numeric( $date ) ) {
			$date = strtotime( $date );

			if ( false === $date ) {
				throw new QueryException( 'Provided datestring ' . $date . ' could not be converted to time' );
			}
		}

		$extracted = [];

		if ( false !== strpos( $extract, 'Y' ) ) {
			$extracted['year'] = date( 'Y', $date );
		}
		if ( false !== strpos( $extract, 'm' ) ) {
			$extracted['month'] = date( 'm', $date );
		}
		if ( false !== strpos( $extract, 'd' ) ) {
			$extracted['day'] = date( 'd', $date );
		}
		if ( false !== strpos( $extract, 'h' ) ) {
			$extracted['hour'] = date( 'h', $date );
		}
		if ( false !== strpos( $extract, 'i' ) ) {
			$extracted['minute'] = date( 'i', $date );
		}
		if ( false !== strpos( $extract, 's' ) ) {
			$extracted['second'] = date( 's', $date );
		}

		return $extracted;
	}

	public function get() {
		$config = [
			'year'   => $this->year,
			'month'  => $this->month,
			'day'    => $this->day,
			'hour'   => $this->hour,
			'minute' => $this->minute,
			'second' => $this->second,
		];

		if ( ! is_null( $this->before ) && ! is_null( $this->after ) ) {
			unset( $config );
			$config           = [];
			$config['before'] = $this->before;
			$config['after']  = $this->after;
		} elseif ( ! is_null( $this->before ) ) {
			unset( $config );
			$config           = [];
			$config['before'] = $this->before;
		} elseif ( ! is_null( $this->after ) ) {
			unset( $config );
			$config          = [];
			$config['after'] = $this->after;
		}


		return $config;
	}


	public static function getKey() {
		return 'date_query';
	}
}