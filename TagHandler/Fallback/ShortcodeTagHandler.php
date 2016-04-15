<?php

namespace Doppy\ShortcodeBundle\TagHandler\Fallback;

use Doppy\Shortcode\HandledShortcode\HandledShortcode;
use Doppy\Shortcode\Shortcode\ShortcodeInterface;
use Doppy\ShortcodeBundle\TagHandler\AbstractTwigTagHandler;

class ShortcodeTagHandler extends AbstractTwigTagHandler
{
    public function handle(ShortcodeInterface $shortcode)
    {
        // prepare render parameters
        $renderParameters = array(
            'shortcode'  => $shortcode->getName(),
            'attributes' => $shortcode->getParameters()
        );

        return new HandledShortcode(
            $shortcode,
            $this->twig->render('DoppyShortcodeBundle:TagHandler/Fallback/ShortcodeTagHandler:prefix.html.twig', $renderParameters),
            $this->twig->render('DoppyShortcodeBundle:TagHandler/Fallback/ShortcodeTagHandler:suffix.html.twig', $renderParameters),
            true
        );
    }
}