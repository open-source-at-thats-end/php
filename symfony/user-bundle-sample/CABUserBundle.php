<?php

namespace CAB\UserBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use FOS\UserBundle\DependencyInjection\Compiler\InjectRememberMeServicesPass;
use FOS\UserBundle\DependencyInjection\Compiler\InjectUserCheckerPass;
use FOS\UserBundle\DependencyInjection\Compiler\ValidationPass;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
class CABUserBundle extends Bundle
{
	/**
	 * @param ContainerBuilder $container
	 */
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new ValidationPass());
		$container->addCompilerPass(new InjectUserCheckerPass());
		$container->addCompilerPass(new InjectRememberMeServicesPass());


	}
	/**
	 * @param ContainerBuilder $container
	 */
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
