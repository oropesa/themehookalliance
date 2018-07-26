<?php
/**
 * Theme Hook Alliance hook stub list.
 *
 * @package  themehookalliance
 * @version  2.0
 * @license  http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined( 'ABSPATH' ) or exit; // Exit if accessed directly

if( ! class_exists( 'THA' ) ) :

    define( 'THA_HOOKS', true );
    define( 'THA_HOOKS_VERSION', '2.0.0' );

    class THA {

        /**
         * An empty constructor. Purposely do nothing here.
         */
        public function __construct() {}

        /**
         * Handles initializing this class and returning the singleton instance after it's been cached.
         *
         * @return null|THA
         */
        public static function get_instance() {
            // Store the instance locally to avoid private static replication
            static $instance = null;

            if( $instance === null ) {
                $instance = new self();
                self::_add_actions();
            }

            return $instance;
        }

        /**
         * Handles registering hooks that initialize this plugin.
         */
        public static function _add_actions() {
            // Declare add_theme_support
            self::_setup();
            // Filter when call for current_theme_support( 'tha_hooks' );
            add_filter( 'current_theme_supports-tha_hooks', array( __CLASS__, '_current_theme_supports' ), 10, 3 );
        }

        /**
         * THA Support
         */

        /**
         * Themes and Plugins can check for tha_hooks using current_theme_supports( 'tha_hooks', $hook )
         * to determine whether a theme declares itself to support this specific hook type.
         *
         * On the setup, it supports all standar sections.
         */
        public static function _setup() {
            add_theme_support( 'tha_hooks', array(
                'html',
                'body',
                'head',
                'header',
                'content',
                'primary',
                'content_while',
                'entry',
                'entry_content',
                'comments',
                'main_sidebar', //secondary
                'footer'
            ) );
        }

        /**
         * Determines, whether the specific hook type is actually supported.
         *
         * Plugin developers should always check for the support of a <strong>specific</strong>
         * hook type before hooking a callback function to a hook of this type.
         *
         * Example:
         * <code>
         *     if( current_theme_supports( 'tha_hooks', 'head' ) ) {
         *         add_action( 'tha_head_top', 'fn_header_top' );
         *     }
         * </code>
         *
         * @param bool $bool true
         * @param array $args The hook type being checked
         * @param array $registered All registered hook types
         *
         * @return bool
         */
        public static function _current_theme_supports( $bool, $args, $registered ) {
            return in_array( $args[ 0 ], $registered[ 0 ] );
        }

        /**
         * THA Add support
         *
         * For the purpose to add new support sections.
         *
         * @param string|array $tha_theme_support
         */
        public static function add_supports( $tha_theme_support ) {
            $current_tha_supports = get_theme_support( 'tha_hooks' )[ 0 ];

            if( gettype( $tha_theme_support ) === 'array' ) {
                $current_tha_supports = array_merge( $current_tha_supports, $tha_theme_support );
            }
            elseif( ! in_array( $tha_theme_support, $current_tha_supports ) ) {
                $current_tha_supports[] = $tha_theme_support;
            }

            add_theme_support( 'tha_hooks', $current_tha_supports );
        }

        /**
         * THA Add support
         *
         * For the purpose to add new support sections.
         *
         * @param string|array $tha_theme_support
         */
        public static function remove_supports( $tha_theme_support ) {
            $current_tha_supports = get_theme_support( 'tha_hooks' )[ 0 ];

            if( gettype( $tha_theme_support ) === 'string' ) { $tha_theme_support = array( $tha_theme_support ); }

            for( $i = 0, $len = count( $tha_theme_support ); $i < $len; $i++ ) {
                if( ( $key = array_search( $tha_theme_support[ 0 ], $current_tha_supports) ) !== false ) {
                    unset( $current_tha_supports[ $key ] );
                }
            }

            add_theme_support( 'tha_hooks', $current_tha_supports );
        }

        /**
         * THA ACTIONS
         */

        /**
         * custom hook
         * For non-standar hooks.
         */
        public static function custom( $key ) { do_action( "tha_$key" ); }

        /**
         * HTML <html> hook
         * Special case, useful for <DOCTYPE>, before to print html checks, etc.
         * $tha_supports[] = 'html';
         */
        public static function html_before() { do_action( 'tha_html_before' ); }

        /**
         * HTML <head> hooks
         * $tha_supports[] = 'head';
         */
        public static function head_top()    { do_action( 'tha_head_top'    ); }
        public static function head_bottom() { do_action( 'tha_head_bottom' ); }

        /**
         * HTML <body> hooks
         * $tha_supports[] = 'body';
         */
        public static function body_top()    { do_action( 'tha_body_top'    ); }
        public static function body_bottom() { do_action( 'tha_body_bottom' ); }

        /**
         * Semantic <header> hooks
         * $tha_supports[] = 'header';
         */
        public static function header_before() { do_action( 'tha_header_before' ); }
        public static function header_after()  { do_action( 'tha_header_after'  ); }
        public static function header_top()    { do_action( 'tha_header_top'    ); }
        public static function header_bottom() { do_action( 'tha_header_bottom' ); }

        /**
         * Semantic <content> hooks
         * $tha_supports[] = 'content';
         */
        public static function content_before()       { do_action( 'tha_content_before'       ); }
        public static function content_after()        { do_action( 'tha_content_after'        ); }
        public static function content_top()          { do_action( 'tha_content_top'          ); }
        public static function content_bottom()       { do_action( 'tha_content_bottom'       ); }

        /**
         * Semantic <content> hooks
         * $tha_supports[] = 'primary';
         */
        public static function primary_before()       { do_action( 'tha_primary_before' ); }
        public static function primary_after()        { do_action( 'tha_primary_after'  ); }
        public static function primary_top()          { do_action( 'tha_primary_top'    ); }
        public static function primary_bottom()       { do_action( 'tha_primary_bottom' ); }

        /**
         * Semantic <content> hooks
         * $tha_supports[] = 'content_while';
         */
        public static function content_while_before() { do_action( 'tha_content_while_before' ); }
        public static function content_while_after()  { do_action( 'tha_content_while_after'  ); }

        /**
         * Semantic <entry> hooks
         * $tha_supports[] = 'entry';
         */
        public static function entry_before()         { do_action( 'tha_entry_before'         ); }
        public static function entry_after()          { do_action( 'tha_entry_after'          ); }
        public static function entry_top()            { do_action( 'tha_entry_top'            ); }
        public static function entry_bottom()         { do_action( 'tha_entry_bottom'         ); }

        /**
         * Semantic <entry> hooks
         * $tha_supports[] = 'entry_content';
         */
        public static function entry_content_before() { do_action( 'tha_entry_content_before' ); }
        public static function entry_content_after()  { do_action( 'tha_entry_content_after'  ); }
        public static function entry_content_top()    { do_action( 'tha_entry_content_top'    ); }
        public static function entry_content_bottom() { do_action( 'tha_entry_content_bottom' ); }

        /**
         * Comments block hooks
         * $tha_supports[] = 'comments';
         */
        public static function comments_before() { do_action( 'tha_comments_before' ); }
        public static function comments_after()  { do_action( 'tha_comments_after'  ); }

        /**
         * Semantic <sidebar> hooks
         * $tha_supports[] = 'main_sidebar';
         */
        public static function main_sidebar_before() { do_action( 'tha_main_sidebar_before' ); }
        public static function main_sidebar_after()  { do_action( 'tha_main_sidebar_after'  ); }
        public static function main_sidebar_top()    { do_action( 'tha_main_sidebar_top'    ); }
        public static function main_sidebar_bottom() { do_action( 'tha_main_sidebar_bottom' ); }

        /**
         * Semantic <footer> hooks
         * $tha_supports[] = 'footer';
         */
        public static function footer_before() { do_action( 'tha_footer_before' ); }
        public static function footer_after()  { do_action( 'tha_footer_after'  ); }
        public static function footer_top()    { do_action( 'tha_footer_top'    ); }
        public static function footer_bottom() { do_action( 'tha_footer_bottom' ); }

    }

    THA::get_instance();

endif;