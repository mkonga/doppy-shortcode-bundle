<?php

namespace Doppy\ShortcodeBundle\TagHandler;

use Doppy\Shortcode\TagHandler\AbstractTagHandler;

abstract class AbstractTwigTagHandler extends AbstractTagHandler
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * SimpleTagHandler constructor.
     *
     * @param string $tagName
     */
    public function __construct($tagName, \Twig_Environment $twig)
    {
        parent::__construct($tagName);
        $this->twig = $twig;
    }
} 