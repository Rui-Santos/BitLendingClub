<?php

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library/externals'),
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap(array('autoload', 'doctrine', 'configs'));
//$application->bootstrap();

try {
    $opts = new Zend_Console_Getopt(array(
        'example-action' => 'Example Action',
        'newsletter' => 'MailChimp Newsletter',
    ));

    $opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    exit($e->getMessage() . "\n\n" . $e->getUsageMessage());
}

if ($opts->getOption('help') || count($opts->getOptions()) == 0) {
    echo $opts->getUsageMessage();
    exit;
}


if ($opts->getOption('example-action')) {
}
if ($opts->getOption('newsletter')) {
    $newsletter = new App_Mailchimp_Newsletter(array('config' => Zend_Registry::get('config')));
    $newsletter->build(true);
}