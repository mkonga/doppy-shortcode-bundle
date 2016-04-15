<?php

namespace Doppy\ShortcodeBundle\ProcessorContainer;

use Doppy\Shortcode\Exception\MissingProcessorException;
use Doppy\Shortcode\Processor\ProcessorInterface;
use Doppy\Shortcode\ProcessorContainer\ProcessorContainerInterface;
use Doppy\ShortcodeBundle\Exception\InvalidProcessorException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ProcessorContainer implements ProcessorContainerInterface
{
    /**
     * @var Container
     */
    protected $serviceContainer;

    /**
     * @var ProcessorInterface[]
     */
    protected $processors = [];

    /**
     * ProcessorContainer constructor.
     *
     * Note: using the Container here because:
     * - we need to prevent a circular reference (caused by using twig)
     * - preventing all Processors to be preloaded (performance gain)
     *
     *
     * @param Container $serviceContainer
     */
    public function __construct(Container $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param string $id
     * @param string $alias
     */
    public function add($id, $alias)
    {
        $this->processors[$alias] = $id;
    }

    /**
     * @param string $name
     *
     * @return null|ProcessorInterface
     */
    public function get($name = 'default')
    {
        if (array_key_exists($name, $this->processors)) {
            try {
                return $this->serviceContainer->get($this->processors[$name]);
            } catch (ServiceNotFoundException $e) {
                throw new InvalidProcessorException('Processor `' . $name . '` is configured, but service is missing', 0, $e);
            }
        } else {
            throw new MissingProcessorException('Processor `' . $name . '` is not configured.');
        }
    }
}