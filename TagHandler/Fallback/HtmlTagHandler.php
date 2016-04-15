<?php

namespace Doppy\ShortcodeBundle\TagHandler\Fallback;

use Doppy\Shortcode\HandledShortcode\HandledShortcode;
use Doppy\Shortcode\Shortcode\ShortcodeInterface;
use Doppy\ShortcodeBundle\TagHandler\AbstractTwigTagHandler;

class HtmlTagHandler extends AbstractTwigTagHandler
{
    /**
     * @var string
     */
    protected $htmlElement;

    /**
     * @var string
     */
    protected $class;

    /**
     * HtmlTagHandler constructor.
     *
     * @param string            $tagName
     * @param \Twig_Environment $twig
     * @param string            $htmlElement
     * @param string            $class
     */
    public function __construct($tagName, \Twig_Environment $twig, $htmlElement = 'div', $class = 'unknown-shortcode')
    {
        parent::__construct($tagName, $twig);
        $this->htmlElement = $htmlElement;
        $this->class       = $class;
    }

    public function handle(ShortcodeInterface $shortcode)
    {
        // prepare render parameters
        $renderParameters = array(
            'shortcode'   => $shortcode->getName(),
            'attributes'  => $shortcode->getParameters(),
            'htmlElement' => $this->htmlElement,
            'class'       => $this->class
        );

        return new HandledShortcode(
            $shortcode,
            $this->twig->render('DoppyShortcodeBundle:TagHandler/Fallback/HtmlTagHandler:prefix.html.twig', $renderParameters),
            $this->twig->render('DoppyShortcodeBundle:TagHandler/Fallback/HtmlTagHandler:suffix.html.twig', $renderParameters),
            true
        );
    }

}