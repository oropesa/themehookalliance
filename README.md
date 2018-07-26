# Theme Hook Alliance #

## Status ##
**2.0.0**

## What? ##
Child theme authors and plugin developers need a consistent set of entry points to allow for easy customization and altering of functionality. 

Core WordPress offers a suite of [action hooks](http://codex.wordpress.org/Plugin_API/Action_Reference/) and [template tags](http://codex.wordpress.org/Template_tags) but does not cover many of the common use cases.
 
The Theme Hook Alliance is a community-driven effort to agree on a set of third-party action hooks that THA themes pledge to implement in order to give that desired consistency.

**From developers to developers.**

The set of third-party action hooks works around the a backbone of the theme, from the head to the footer.

With this kind of *backbone hooks*, we are allowing our theme to be customized by oneself, or by others developers with a child-theme.

## Why? ##
There have been [discussions](http://www.wptavern.com/forum/themes-templates/494-standard-theme-hook-names.html) about implementing a common set of hooks, a [Trac ticket](http://core.trac.wordpress.org/ticket/18561#comment:92) and even an [initial pass](http://codex.wordpress.org/User_talk:Dcole07) at implementing something similar. However, for whatever reason[s], these efforts have not gained traction. 

[Doug Stewart](https://github.com/zamoose) proposed this third-party solution [here](http://literalbarrage.org/blog/2012/06/29/wordpress-theme-hook-alliance) and that project was intended to be an implementation of these goals. This initiative had its [first version](https://github.com/zamoose/themehookalliance) and was stopped in 2015. 

As a theme & plugin developer, I found that implementation really usefull, so I have decided to create a second version (small object-oriented), reusing the first version and optimizing certain features.

## How to implement it in your own theme ##

1. Copy `tha-theme-hooks.php` to a directory inside of your theme; i.e., `inc/`, for instance.
2. Include `tha-theme-hooks.php` in your `functions.php` or similar, as `<?php include( 'inc/tha-theme-hooks.php' ); ?>`.
3. Using `tha-example-index.php` as a guide, *be sure to implement all of the hooks described in `tha-theme-hooks.php` in order to offer *full compatibility*.

```php
<?php THA::html_before() ?>
<head>
    <!-- ... -->
    <?php
    THA::head_top();    // before wp_head
    wp_head();          // wp_head
    THA::head_bottom(); // after wp_head
    ?>
</head>
<body>
    <?php THA::body_top() ?>
    ...
```

## How to use it ##

Just call an `add_action` in `functions.php` or similars with the code that you want to add in the section what you want.

```php
   <?php
   function my_custom_body_top() { echo 'Hello world!'; }
   add_action( 'tha_body_top', 'my_custom_body_top' );
```

If you know more about `add_action`, you can choose your priority to sort your different codes in the same *action*.

```php
   add_action( 'tha_body_top', 'my_custom_body_top'      , 10 ); //default is 10
   add_action( 'tha_body_top', 'my_custom_body_top_first',  5 );
   add_action( 'tha_body_top', 'my_custom_body_top_last' , 15 );
```

On the other hand, if it exists other custom action that you don't want, you can also remove it.

```php
   <?php
   remove_action( 'tha_body_top', 'other_custom_body_top' );
```

## Customization ##

As a theme developer, if you want to give THA-support only in specific sections, you can remove the sections that you doesn't want with the function `THA::remove_supports`.

```php
    THA::remove_supports( 'content_while' );
```
```php
    THA::remove_supports( array( 'content_while', 'main_sidebar' ) );
```

On the other hand, you can add your own custom sections with the function `THA::add_supports`.

```php
    THA::add_supports( 'my_contact' );
```
```php
    THA::add_supports( array( 'my_contact', 'my_widget' ) );
```

And, you can also add a custom action hook with `THA::custom( $key )`

```php
    <?php THA::custom( 'my_contact_before' ); ?>
    <div class="contact">
        <?php THA::custom( 'my_contact_top' ); ?>
        <!-- ... -->
        <?php THA::custom( 'my_contact_bottom' ); ?>
    </div>
    <?php THA::custom( 'my_contact_after' ); ?>
```
```php
   <?php
   function my_custom_contact_top() { echo 'Hello world!'; }
   add_action( 'tha_my_contact_top', 'my_custom_contact_top' );
```

## Check support for plugins and child themes ##

As a third-party developer (plugin or child-theme developer), you can check if the current theme use THA, or if it supports a specific section.

To check if THA exists, just check if the variable `THA_HOOKS` is defined.

```php
    if( defined( 'THA_HOOKS' ) ) {
        // THA is available
    }
```

To check if a specific section of THA is available, just use the function `current_theme_support()`.

```php
    if( current_theme_supports( 'tha_hooks', 'body' ) ) {
        add_action( 'tha_body_top', 'my_custom_body_top' );
    }
```

And, you can check custom sections too (if you added it before).

```php
    if( current_theme_supports( 'tha_hooks', 'my_contact' ) ) {
        add_action( 'tha_my_contact_top', 'my_custom_contact_top' );
    }
```

## Naming conventions ##

* Hooks should be of the form 	`tha_` + `[section of the theme]` + `_` + `[placement within block]`.
* Hooks should be suffixed based upon their **placement within a block**.
	* Hooks immediately *preceding* a block should use `_before`.
	* Hooks immediately *following* a block should use `_after`.
	* Hooks placed at the very *beginning* of a block should use `_top`.
	* Hooks placed at the very *end* of a block should use `_bottom`.

## Standard sections and action hooks ##

* html
    * tha_html_before
* body
    * tha_head_top
    * tha_head_bottom
* head
    * tha_body_top
    * tha_body_bottom
* header
    * tha_header_before
    * tha_header_after
    * tha_header_top
    * tha_header_bottom
* content
    * tha_content_before
    * tha_content_after
    * tha_content_top
    * tha_content_bottom
* primary
    * tha_primary_before
    * tha_primary_after
    * tha_primary_top
    * tha_primary_bottom
* content_while
    * tha_content_while_before
    * tha_content_while_after
* entry
    * tha_entry_before
    * tha_entry_after
    * tha_entry_top
    * tha_entry_bottom
* entry_content
    * tha_entry_content_before
    * tha_entry_content_after
    * tha_entry_content_top
    * tha_entry_content_bottom
* comments
    * tha_comments_before
    * tha_comments_after
* main_sidebar
    * tha_main_sidebar_before
    * tha_main_sidebar_after
    * tha_main_sidebar_top
    * tha_main_sidebar_bottom
* footer
    * tha_footer_before
    * tha_footer_after
    * tha_footer_top
    * tha_footer_bottom