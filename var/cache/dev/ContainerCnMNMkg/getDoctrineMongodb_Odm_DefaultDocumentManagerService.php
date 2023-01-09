<?php

namespace ContainerCnMNMkg;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrineMongodb_Odm_DefaultDocumentManagerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'doctrine_mongodb.odm.default_document_manager' shared service.
     *
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/DocumentManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/Configuration.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/Mapping/Driver/MappingDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/Mapping/Driver/MappingDriverChain.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Driver/CompatibilityAnnotationDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/Mapping/Driver/ColocatedMappingDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Driver/AnnotationDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/Repository/RepositoryFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm-bundle/Repository/ContainerRepositoryFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/event-manager/src/EventManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/ContainerAwareEventManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm-bundle/ManagerConfigurator.php';

        $a = new \Doctrine\ODM\MongoDB\Configuration();

        $b = new \Doctrine\Persistence\Mapping\Driver\MappingDriverChain();
        $b->addDriver(new \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver(($container->privates['annotations.cached_reader'] ?? $container->getAnnotations_CachedReaderService()), [0 => (\dirname(__DIR__, 4).'/src/Document')]), 'App\\Document');

        $a->setDocumentNamespaces(['App' => 'App\\Document']);
        $a->setMetadataCache(new \Symfony\Component\Cache\Adapter\ArrayAdapter());
        $a->setMetadataDriverImpl($b);
        $a->setProxyDir(($container->targetDir.''.'/doctrine/odm/mongodb/Proxies'));
        $a->setProxyNamespace('MongoDBODMProxies');
        $a->setAutoGenerateProxyClasses(2);
        $a->setHydratorDir(($container->targetDir.''.'/doctrine/odm/mongodb/Hydrators'));
        $a->setHydratorNamespace('Hydrators');
        $a->setAutoGenerateHydratorClasses(1);
        $a->setDefaultDB($container->getEnv('resolve:MONGODB_DB'));
        $a->setDefaultCommitOptions([]);
        $a->setDefaultDocumentRepositoryClassName('Doctrine\\ODM\\MongoDB\\Repository\\DocumentRepository');
        $a->setDefaultGridFSRepositoryClassName('Doctrine\\ODM\\MongoDB\\Repository\\DefaultGridFSRepository');
        $a->setPersistentCollectionDir(($container->targetDir.''.'/doctrine/odm/mongodb/PersistentCollections'));
        $a->setPersistentCollectionNamespace('PersistentCollections');
        $a->setAutoGeneratePersistentCollectionClasses(0);
        $a->setRepositoryFactory(new \Doctrine\Bundle\MongoDBBundle\Repository\ContainerRepositoryFactory(($container->privates['.service_locator.Xbsa8iG'] ??= new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [], []))));

        $container->services['doctrine_mongodb.odm.default_document_manager'] = $instance = \Doctrine\ODM\MongoDB\DocumentManager::create(($container->services['doctrine_mongodb.odm.default_connection'] ?? $container->load('getDoctrineMongodb_Odm_DefaultConnectionService')), $a, new \Symfony\Bridge\Doctrine\ContainerAwareEventManager($container));

        (new \Doctrine\Bundle\MongoDBBundle\ManagerConfigurator([]))->configure($instance);

        return $instance;
    }
}
