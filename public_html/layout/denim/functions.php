<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | functions.php                                                             |
// |                                                                           |
// | Functions implementing the theme API                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
// |          Rouslan Placella  - rouslan AT placella DOT com                  |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Return the configuration values for the theme
 */
function theme_config_denim()
{
    $options = array(
        'uikit_theme' => 'default', // you can set this variable to 'default' or 'gradient' or 'almost-flat'
        'uikit_components'  => array(
            'accordion'     => 0,
            'autocomplete'  => 0,
            'datepicker'    => 0,
            'dotnav'        => 0,
            'form_advanced' => 0,
            'form_file'     => 0,
            'form_password' => 0,
            'form_select'   => 0,
            'htmleditor'    => 0,
            'nestable'      => 0,
            'notify'        => 0,
            'placeholder'   => 0,
            'progress'      => 1,
            'search'        => 0,
            'slidenav'      => 0,
            'slider'        => 0,
            'slideshow'     => 0,
            'sortable'      => 0,
            'sticky'        => 0,
            'tooltip'       => 1,
            'upload'        => 0,
        ),
        'use_minified_css'  => 0,   // 1:use  or 0:no_use minified css
        'header_search'     => 1,   // 1:show or 0:hide header searchbox
        'block_left_search' => 1,   // 1:show or 0:hide left block searchbox
        'welcome_msg'       => 1,   // 1:show or 0:hide welcome message
        'trademark_msg'     => 0,   // 1:show or 0:hide trademark message on footer
        'execution_time'    => 0,   // 1:show or 0:hide execution time on footer
        'pagenavi_string'   => 1,   // 1:show or 0:hide text string of page navigation
        'header_brand_type' => 1,   // 1:text or 0:image type of header brand (site name)
        'off_canvas_mode'   => 2,   // 0:push 1:slide 2:reveal or 3:none mode of UIkit off-canvas animation
    );

    return array(
        'image_type' => 'png',
        'doctype'    => 'xhtml5',
        'supported_version_theme' => '2.0.0', // support new theme format for the later Geeklog 2.0.0
        'theme_plugins' => 'denim', // Not requred, you can specify compatible theme of template stored with some plugins
        'options'    => $options // Not requred, some options of this theme
    );
}

/**
 * Return an array of CSS files to be loaded
 */
function theme_css_denim()
{
    global $_CONF, $LANG_DIRECTION;

    $theme_var = theme_config_denim();

    $direction = ($LANG_DIRECTION === 'rtl') ? '_rtl' : '';
    $ui_theme = '';
    if (in_array($theme_var['options']['uikit_theme'], array('gradient', 'almost-flat'))) {
        $ui_theme = '.' . $theme_var['options']['uikit_theme'];
    }
    $min = ($theme_var['options']['use_minified_css'] === 1) ? '.min' : '';

    $result = array();
    $result[] = array(
        'name'       => 'uikit',
        'file'       => '/vendor/uikit/css' . $direction . '/uikit' . $ui_theme . $min . '.css',
        'attributes' => array('media' => 'all'),
        'priority'   => 80
    );

    $result[] = array(
        'name'       => 'main', // don't use the name 'theme' to control the priority
        'file'       => '/layout/' . $_CONF['theme'] . '/css_' . $LANG_DIRECTION . '/style' . $ui_theme . $min . '.css',
        'attributes' => array('media' => 'all')
    );

    if (!empty($theme_var['options']['uikit_components'])) {
        $uikit_components = array_merge($theme_var['options']['uikit_components']);
        foreach ($uikit_components as $component => $value) {
            if ($value !== 1) continue;
            $componame = str_replace('_', '-', $component);
            $result[] = array(
                'name'     => 'uk_' . $component,
                'file'     => '/vendor/uikit/css' . $direction . '/components/' . $componame . $ui_theme . $min . '.css',
                'priority' => 81
            );
        }
    }

    return $result;
}

/**
 * Return an array of JS libraries to be loaded
 */
function theme_js_libs_denim()
{
    return array(
       array(
            'library' => 'jquery',
            'footer'  => false // Not required, default = true
        )
    );
}

/**
 * Return an array of JS files to be loaded
 */
function theme_js_files_denim()
{
    global $_CONF;

    $theme_var = theme_config_denim();

    $result = array();
    $result[] = array(
        'file'     => '/vendor/uikit/js/uikit.js',
        'footer'   => false, // Not required, default = true
        'priority' => 100 // Not required, default = 100
    );

    $result[] = array(
        'file'     => '/layout/' . $_CONF['theme'] . '/javascript/script.js',
        'footer'   => true, // Not required, default = true
        'priority' => 100 // Not required, default = 100
    );

    if (!empty($theme_var['options']['uikit_components'])) {
        $uikit_components = array_merge($theme_var['options']['uikit_components']);
        foreach ($uikit_components as $component => $value) {
            if ($value !== 1) continue;
            $componame = str_replace('_', '-', $component);
            $result[] = array(
                'file'     => '/vendor/uikit/js/components/' . $componame . '.js',
                'footer'   => false,
                'priority' => 110
            );
        }
    }

    return $result;
}

/**
 * Do any other initialisation here
 */
function theme_init_denim()
{
    global $_BLOCK_TEMPLATE, $_CONF;

    $_CONF['left_blocks_in_footer'] = 1;
    
    $_CONF['theme_oauth_icons'] = 0; // Default is false (not required). Will use Geeklogs own OAuth icons for login form else use icons in theme images directory

    /*
     * For left/right block support there is no longer any need for the theme to
     * put code into functions.php to set specific templates for the left/right
     * versions of blocks. Instead, Geeklog will automagically look for
     * blocktemplate-left.thtml and blocktemplate-right.thtml if given
     * blocktemplate.thtml from $_BLOCK_TEMPLATE. So, if you want different left
     * and right templates from admin_block, just create blockheader-list-left.thtml
     * etc.
     */

    $_BLOCK_TEMPLATE['_msg_block'] = 'blockheader-message.thtml,blockfooter-message.thtml';
    $_BLOCK_TEMPLATE['configmanager_block'] = 'blockheader-config.thtml,blockfooter-config.thtml';
    $_BLOCK_TEMPLATE['configmanager_subblock'] = 'blockheader-config.thtml,blockfooter-config.thtml';
    $_BLOCK_TEMPLATE['whats_related_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';
    $_BLOCK_TEMPLATE['story_options_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';

    // Define the blocks that are a list of links styled as an unordered list - using class="blocklist"
    $_BLOCK_TEMPLATE['admin_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    $_BLOCK_TEMPLATE['section_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';

    if (!COM_isAnonUser()) {
        $_BLOCK_TEMPLATE['user_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    }
}
