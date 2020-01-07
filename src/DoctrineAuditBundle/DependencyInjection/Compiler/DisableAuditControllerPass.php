<?php

declare(strict_types=1);

namespace DH\DoctrineAuditBundle\DependencyInjection\Compiler;

use DH\DoctrineAuditBundle\Controller\AuditController;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DisableAuditControllerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('dh_doctrine_audit.configuration')) {
            return;
        }

        $config = $container->getParameter('dh_doctrine_audit.configuration');
        if (null === $config['enable_audit_controller']) {
            return;
        }

        if (!$container->hasDefinition(AuditController::class)) {
            return;
        }

        if (false === $config['enable_audit_controller']) {
            $container->removeDefinition(AuditController::class);
        }
    }
}
