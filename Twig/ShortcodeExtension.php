<?php

namespace Doppy\ShortcodeBundle\Twig;

use Doppy\ShortcodeBundle\ProcessorContainer\ProcessorContainer;

class ShortcodeExtension extends \Twig_Extension
{
    /**
     * @var ProcessorContainer
     */
    protected $processorContainer;

    /**
     * ShortcodeExtension constructor.
     *
     * @param ProcessorContainer $processorContainer
     */
    public function __construct(ProcessorContainer $processorContainer)
    {
        $this->processorContainer = $processorContainer;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'shortcode',
                array($this, 'shortcode'),
                array('is_safe' => array('html'))
            )
        );
    }

    public function shortcode($text, $processor = 'default')
    {
        $processor = $this->processorContainer->get($processor);
        return $processor->parse($text);
    }

    public function getName()
    {
        return 'doppy_shortcode';
    }
}