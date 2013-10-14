<?php
/**
 * Arabic Stopwords manager.
 *
 * @since 0.1
 */
class Arabic_Stopwords {

	/**
	 * Arabic stopwords list.
	 *
	 * @var array
	 * @since 0.1
	 */
	protected static $stopwords = array();

	/**
	 * Get the Arabic stopwords list.
	 *
	 * @return array
	 * @since 0.1
	 */
	public static function get_list() {

		if ( empty( self::$stopwords ) )
			self::load_default_list();

		return self::$stopwords;

	} // end get_list()

	/**
	 * Remove the common Arabic words from a string.
	 *
	 * @return string
	 * @since 0.1
	 */
	public static function clean_common( $str, $normalize = true ) {

		if ( $normalize )
			$str = ArWP_normalize( $str );

		$str = str_replace( self::get_list(), '', $str );

		return $str;

	} // end clean_common()

	/**
	 * Check if the given words are in stopwords.
	 *
	 * @return bool
	 * @since 0.1
	 */
	public static function in_list( $words, $normalize = true ) {

		$words = self::parse_words( $words );

		foreach( $words as &$word ) {

			$word = trim( $word );

			if ( $normalize )
				$word = ArWP_normalize( $word );

		} // end foreach

		foreach( self::get_list() as $stopword ) {

			foreach( $words as $word ) {

			if ( $stopword === $word )
				return true;

			} // end foreach

		} // end foreach

		return false;

	} // end in_list()

	/**
	 * Load the default Arabic stopwords list.
	 *
	 * @return bool
	 * @since 0.1
	 */
	public static function load_default_list() {

		$words = file( ArSWs_PATH . 'data/ar-stopwords.txt', FILE_IGNORE_NEW_LINES );

		if ( empty( $words ) )
			return false;

		self::set_list( $words, true );

		return true;

	} // end load_default_list()

	/**
	 * Load the extra Arabic stopwords list.
	 *
	 * @return bool
	 * @since 0.1
	 */
	public static function load_extra_list() {

		$words = file( ArSWs_PATH . 'data/ar-extra-stopwords.txt', FILE_IGNORE_NEW_LINES );

		if ( empty( $words ) )
			return false;

		self::set_list( $words, true );

		return true;

	} // end load_extra_list()

	/**s
	 * Set the Arabic stopwords list.
	 *
	 * @return void
	 * @since 0.1
	 */
	public static function set_list( $stopwords, $append = false ) {

		$stopwords = self::parse_words( $stopwords );

		if ( $append )
			self::$stopwords += $stopwords;
		else
			self::$stopwords = $stopwords;

	} // end set_list()

	protected static function parse_words( $words ) {

		if ( is_array( $words ) )
			return $words;

		$words = explode( ' ', $words );

		return $words;

	} // end parse_words()

} // end class Arabic_Stopwords