<?php

namespace Doppy\ShortcodeBundle;

use Doppy\ShortcodeBundle\DependencyInjection\CompilerPass\TagHandlerCompilerPass;
use Doppy\ShortcodeBundle\DependencyInjection\CompilerPass\ConfiguredProcessorCompilerPass;
use Doppy\ShortcodeBundle\DependencyInjection\CompilerPass\ProcessorContainerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoppyShortcodeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TagHandlerCompilerPass());
        $container->addCompilerPass(new ConfiguredProcessorCompilerPass());
        $container->addCompilerPass(new ProcessorContainerCompilerPass());
    }
}
