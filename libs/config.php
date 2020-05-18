<?php
/**
 * System configurations.
 * 
 * @package DB Storage
 * @author  Bin Emmanuel https://github.com/binemmanuel
 * @license GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/
 * @link    https://github.com/db-storage
 *
 * @version	1.0
 */
// Initialize session.
session_start();

/**
 * Class Directory.
 */
define('CLASS_DIR', 'libs/classes/');

/**
 * Upload Directory.
 */
define('UPLOAD_DIR', 'uploads' . DIRECTORY_SEPARATOR);
define('IMAGE_PATH', UPLOAD_DIR .'images'. DIRECTORY_SEPARATOR);
define('VIDEO_PATH', UPLOAD_DIR .'videos'. DIRECTORY_SEPARATOR);
define('AUDIO_PATH', UPLOAD_DIR .'audios'. DIRECTORY_SEPARATOR);
define('ZIP_PATH', UPLOAD_DIR .'zips'. DIRECTORY_SEPARATOR);
define('OTHER_FILES_PATH', UPLOAD_DIR .'other-files'. DIRECTORY_SEPARATOR);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database */
define('DB_NAME', 'dbstorage');

/** MySQL database username */
define('DB_USER', 'binemmanuel');

/** MySQL database password */
define('DB_PASSWORD', 'SMARTlogin89');

/** MySQL hostname */
define('DB_SERVER', 'localhost');


/** Mail configurations */
define('SMTP_HOST', 'smtp_host_here');
define('SMTP_DEBUG', false);
define('SMTP_SECURE_TLS', 'tls');
define('SMTP_PORT', 'smtp_port_here');

/**
 * For developers: Dragon Programming Forum debugging mode.
 *
 * Configure error reporting options
 * Change this to false to enable the display of notices during development.
 */
define('IS_ENV_PRODUCTION', false);

// Turn on error reporting
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', !IS_ENV_PRODUCTION);

// ** Set time zone to use date/time functions without warnings ** //
date_default_timezone_set('Africa/Lagos'); //http://www.php.net/manual/en/timezones.php

// Check if "log" folder exists.
if (!file_exists('../log')) {
    // Create the "log" folder.
    mkdir('../log');
} else {
    // Set error log.
    ini_set('error_log', 'log/php-error.txt');
}
