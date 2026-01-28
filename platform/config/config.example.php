<?php
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */

/**
 * Define public assets path in /public/
 */
const ASSETS_PATH = 'project';

/**
 * Copy this file to config.php in order to not have db credentials versioned via git (!!!)
 */
$cfgAppLocal__ = array(
    /**
     * Default settings (used also as production)
     */
    'production' => array(
        'common' => array(
            /**
             * Database connections
             */
            'db' => array(
                'main' => array(
                    'host' => '',
                    'user' => '',
                    'pass' => '',
                    'db' => ''
                ),
            ),
        ),
        'front' => array(
            /**
             * Debug settings
             */
            'debug' => array(
                'on' => false
            ),
            'lazyLoad' => true,
            'compressHtml' => false
        ),
        'admin' => array(
            /**
             * Debug settings
             */
            'debug' => array(
                'on' => false
            ),
            /**
             * Login settings
             */
            'login' => array(
                'settings' => array(
                    'user_pass' => true,
                    'google' => true,
                    'facebook' => false,
                    'microsoft' => false
                )
            ),
            /**
             *  Content settings
             */
            'cms' => array(
                /**
                 * Title tag
                 */
                'title' => ''
            )
        )
    ),
    'development' => array(
        'common' => array(
            /**
             * Database connections
             */
            'db' => array(
                'main' => array(
                    'host' => '',
                    'user' => '',
                    'pass' => '',
                    'db' => ''
                )
            )
        ),
        'front' => array(
            /**
             * Debug settings
             */
            'debug' => array(
                'on' => true
            ),
            'lazyLoad' => true,
            'compressHtml' => false,
        ),
        'admin' => array(
            /**
             * Debug settings
             */
            'debug' => array(
                'on' => true
            ),
            'cms' => array(
                /**
                 * Title tag
                 */
                'title' => ''
            )
        )
    )
);
