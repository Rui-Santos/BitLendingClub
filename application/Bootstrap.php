<?php

/**
 * 
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initRegistry()
    {
        $registry = Zend_Registry::getInstance();
        return $registry;
    }

    /**
     * 
     */
    protected function _initHelpers()
    {

        Zend_Controller_Action_HelperBroker::addHelper(
                new App_Controller_Action_Helper_Authentication()
        );
    }

    /**
     *
     * @return Zend_Application_Module_Autoloader 
     */
    protected function _initAutoload()
    {
        $this->getApplication()->setAutoloaderNamespaces(array('APP_'));

        $autoloader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => dirname(__FILE__),
                ));
        $autoloader->addResourceType('library_files', '../library/', '');
        $autoloader->addResourceType('entities', 'models/Entities', 'Entity');
        $autoloader->addResourceType('repositories', 'models/Repositories', 'Repository');
        $autoloader->addResourceType('models', 'models/', 'Model');
        $autoloader->addResourceType('entities_proxies', 'models/Entities/Proxies', 'Entity_Proxy');

        return $autoloader;
    }

    /**
     * Loading config files to zend registry
     */
    protected function _initConfigs()
    {
        Zend_Registry::set('config', new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV));
        Zend_Registry::set('configArray', $this->getOptions());
    }

    /**
     *
     * @return Zend_Locale 
     */
    protected function _initLocale()
    {
        $locale = new Zend_Locale();
        $locale->setDefault('en_US');
        $locale->setLocale('en_US');
        Zend_Registry::set('Zend_Locale', $locale);
        return $locale;
    }

    /**
     *
     * @return type 
     */
    protected function _initDoctrine()
    {
        // include and register Doctrine's class loader
        require_once('Doctrine/Common/ClassLoader.php');
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_PATH . '/../library/externals');
        $classLoader->register();

        // create the Doctrine configuration
        $config = new \Doctrine\ORM\Configuration();

        // setting the cache ( to ArrayCache. Take a look at
        // the Doctrine manual for different options ! )
        $cache = new \Doctrine\Common\Cache\ArrayCache;
        //$cache = new \Doctrine\Common\Cache\ApcCache;

        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        // choosing the driver for our database schema
        // we'll use annotations
        $driver = $config->newDefaultAnnotationDriver(
                APPLICATION_PATH . '/models'
        );
        $config->setMetadataDriverImpl($driver);

        // set the proxy dir and set some options
        $config->setProxyDir(APPLICATION_PATH . '/data/Proxies');
//        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyNamespace('Proxies');

        // now create the entity manager and use the connection
        // settings we defined in our application.ini
        $connectionSettings = $this->getOption('doctrine');
        $conn = array(
            'driver' => $connectionSettings['conn']['driv'],
            'user' => $connectionSettings['conn']['user'],
            'password' => $connectionSettings['conn']['pass'],
            'dbname' => $connectionSettings['conn']['dbname'],
            'host' => $connectionSettings['conn']['host']
        );
        $entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

        // push the entity manager into our registry for later use
        $registry = Zend_Registry::getInstance();
        $registry->em = $entityManager;

        if ($connectionSettings['validate_schema'] == '1') {
            //$validator = new Doctrine\ORM\Tools\SchemaValidator($entityManager);
            //$errors = $validator->validateMapping();
        }
        return $entityManager;
    }

    /**
     * 
     */
    protected function _initTranslate()
    {
        $locale = $this->_initLocale();
        $translate = new Zend_Translate(
                        array(
                            'adapter' => 'ini',
                            'content' => APPLICATION_PATH . '/languages/en.ini',
                            'locale' => $locale->getLanguage()
                        )
        );
        Zend_Registry::set('Zend_Translate', $translate);
    }

    /**
     * 
     */
    protected function _initExceptions()
    {
        Zend_Loader::loadClass('ItemNotFoundException', array(APPLICATION_PATH . '/../library/App/Exceptions/'));
        Zend_Loader::loadClass('PageNotFoundException', array(APPLICATION_PATH . '/../library/App/Exceptions/'));
        Zend_Loader::loadClass('WidgetException', array(APPLICATION_PATH . '/../library/App/Exceptions/'));
        Zend_Loader::loadClass('NewsletterException', array(APPLICATION_PATH . '/../library/App/Exceptions/'));
    }

    /**
     * 
     */
    protected function _initNavigation()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');

        $navigation = new Zend_Navigation($config);
        $view->navigation($navigation);


        //$frontController = Zend_Controller_Front::getInstance();
        //$view->page = $frontController->getParam('page');
        //$view->instructCategories = new Model_Category();
    }

    protected function _initViewScripts()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->addScriptPath(APPLICATION_PATH . '/views/scripts/');
        Zend_Registry::set('viewObj', $view);
        return $view;
    }

    /**
     * 
     */
    protected function _initRouter()
    {
        
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute(
                'content', new Zend_Controller_Router_Route('content/:slug',
                        array( 'module' => 'default', 
                            'controller' => 'pages',
                            'action' => 'index'))
        );
        $router->addRoute(
                'categories', new Zend_Controller_Router_Route('trainers/training-categories',
                        array( 'module' => 'default',
                            'controller' => 'category',
                            'action' => 'index'))
        );
        $router->addRoute(
                'categories_inside', new Zend_Controller_Router_Route('it-trainers/:slug/:page',
                        array( 'module' => 'default',
                            'controller' => 'category',
                            'action' => 'category', 
                            'page' => 1))
        );
        $router->addRoute(
                'instructors_page', new Zend_Controller_Router_Route('trainer/:id',
                        array( 'module' => 'default',
                            'controller' => 'Instructor',
                            'action' => 'index'))
        );
          $router->addRoute(
                'contact_us', new Zend_Controller_Router_Route('contact-us/',
                        array( 'module' => 'default',
                            'controller' => 'Contact',
                            'action' => 'index'))
        );
    }

}

