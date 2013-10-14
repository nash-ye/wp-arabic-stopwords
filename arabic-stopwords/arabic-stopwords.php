<?php
/**
 * Plugin Name: Arabic Stopwords
 * Plugin URI: http://ar.wordpress.org
 * Description: An advance plugin to check the Arabic stopwods.
 * Author: ArWP Team
 * Author URI: http://ar.wordpress.org
 * Version: 0.1
 *
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright (c) 2013 - 2014 Nashwan Doaqan.  All rights reserved.
 */

/**
 * Arabic stop-words manager.
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
    protected static $stopwords;

    /**
     * Get the Arabic stopwords list.
     *
     * @return array
     * @since 0.1
     */
    public static function get_list() {

	if ( ! isset( self::$stopwords ) )
	    self::load_default_list();

	return self::$stopwords;

    } // end get_list()

    /**
     * Remove the common Arabic words from a string.
     *
     * @return string
     */
    public static function clean_common( $str, $normalize = true ) {

	if ( $normalize )
	    $str = normalize_arabic_text( $str );

	$str = str_replace( self::get_list(), '', $str );
	return $str;

    } // end clean_common()

    /**
     * Check if the given word is Arabic stopword.
     *
     * @return bool
     * @since 0.1
     */
    public static function is_stopword( $word, $normalize = true ) {

	if ( $normalize )
	    $word = normalize_arabic_text( $word );

	return in_array( $word, self::get_list(), true );

    } // end is_stopword()

    /**
     * Load the default Arabic stopwords list.
     *
     * @return bool
     * @since 0.1
     */
    public static function load_default_list() {

	$words = self::parse_file( dirname(__FILE__) . '/data/ar-stopwords.txt' );

	if ( ! is_array( $words ) )
	    return false;

	self::set_list( $words );
	return true;

    } // end load_default_list()

    /**
     * Load the extra Arabic stopwords list.
     *
     * @return bool
     * @since 0.1
     */
    public static function load_extra_list() {

	$words = self::parse_file( dirname(__FILE__) . '/data/ar-extra-stopwords.txt' );

	if ( ! is_array( $words ) )
	    return false;

	self::set_list( $words, true );
	return true;

    } // end load_extra_list()

    /**
     * Reads words list file into an array.
     *
     * @return array
     * @since 0.1
     */
    public static function parse_file( $file ) {
	return file( $file, FILE_IGNORE_NEW_LINES );
    } // end parse_file()

    /**
     * Set the Arabic stopwords list.
     *
     * @return void
     * @since 0.1
     */
    public static function set_list( $stopwords, $append = false ) {

	if ( is_array( $stopwords ) ) {

	    if ( $append )
		self::$stopwords += $stopwords;
	    else
		self::$stopwords = $stopwords;

	} // end if

    } // end set_list()

} // end class Arabic_Stopwords

//*** Helpers *****************************************************************/

/**
 * Normalized Arabic string.
 *
 * @return string
 * @since 0.1
 */
function normalize_arabic_text( $str ) {

    $old = $str;

    // Normalize the Alef.
    $str = str_replace( array(
	'أ','إ','آ'
    ), 'ا', $str );

    // Normalize the Diacritics.
    $str = str_replace( array(
	'َ','ً','ُ','ٌ','ِ','ٍ','ْ','ّ'
    ), '', $str );

    return apply_filters( 'normalize_arabic_text', $str, $old );

} // end normalize_arabic_text()

/**
 * Sanitizes an Arabic search term.
 *
 * @return string
 * @since 0.1
 */
function sanitize_arabic_search_term( $term ) {

    $old = $term;
    $term = normalize_arabic_text( $term );

    if ( Arabic_Stopwords::is_stopword( $term, false ) )
	$term = '';

    return apply_filters( 'sanitize_arabic_search_term', $term, $old );

} // end sanitize_arabic_search_term()

//*** Hooking *****************************************************************/

// WP 3.7 (trunk) hooks.
add_filter( 'wp_search_stopwords', array( 'Arabic_Stopwords', 'get_list' ) );
add_filter( 'wp_search_term', 'sanitize_arabic_search_term' );