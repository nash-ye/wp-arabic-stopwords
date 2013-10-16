<?php

//*** Helpers *****************************************************************/

if ( ! function_exists( 'ArWP_normalize' ) ) {

/**
 * Normalize an Arabic string.
 *
 * @return string
 * @since 0.1
 */
function ArWP_normalize( $str ) {

	// Normalize the Alef.
	$str = str_replace( array(
		'أ','إ','آ'
	), 'ا', $str );

	// Normalize the Diacritics.
	$str = str_replace( array(
		'َ','ً','ُ','ٌ','ِ','ٍ','ْ','ّ'
	), '', $str );

	// Return the new string.
	return $str;

} // end ArWP_normalize()

} // end if

//*** WP 3.7 Search ***********************************************************/

add_filter( 'wp_search_term', 'sanitize_arabic_search_term' );

/**
 * Sanitizes an Arabic search term.
 *
 * @return string
 * @since 0.1
 */
function sanitize_arabic_search_term( $term ) {

	$term = ArWP_normalize( $term );

	if ( Arabic_Stopwords::in_list( $term, false ) )
		$term = '';

	return $term;

} // end ArSW_sanitize_search_term()

add_filter( 'wp_search_stopwords', 'add_arabic_search_stopwords' );

/**
 * Add the Arabic stopwords to WP search stopwords list.
 *
 * @return string
 * @since 0.1
 */
function add_arabic_search_stopwords( $stopwords ) {

	$stopwords = (array) $stopwords;
	$stopwords += Arabic_Stopwords::get_list();

	return $stopwords;

} // end add_arabic_search_stopwords()

add_filter('wp_unique_post_slug', 'remove_stopwords_from_slug');

/**
 * Remove Arabic Stopwords from slug of the newly added or edited posts.
 *
 * @return string
 * @since 0.1
 */
function remove_stopwords_from_slug( $slug ) {

	$slug = urldecode( $slug );
	
	$slug = ArWP_normalize( $slug );
	
	$slug = explode( '-', $slug );
	
	foreach( $slug as $key => $slugitem ) {
	
	if ( in_array($slugitem, Arabic_Stopwords::get_list() ) ) 
		unset( $slug[$key] );
		
	}
	
	$slug = implode( '-', $slug );
	$slug = utf8_uri_encode( $slug );
	
	return $slug;

} // end remove_stopwords_from_slug()
