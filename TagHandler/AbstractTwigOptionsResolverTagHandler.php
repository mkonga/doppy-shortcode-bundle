<?php

namespace Doppy\ShortcodeBundle\TagHandler;

use Doppy\Shortcode\HandledShortcode\HandledShortcode;
use Doppy\Shortcode\HandledShortcode\HandledShortcodeInterface;
use Doppy\Shortcode\Shortcode\ShortcodeInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTwigOptionsResolverTagHandler extends AbstractTwigTagHandler
{
    /**
     * @var OptionsResolver
     */
    private $_optionsResolver;

    public function handle(ShortcodeInterface $shortcode)
    {
        // get options
        $options = $this->getOptions($shortcode);

        // resolve options
        try {
            $options = $this->getOptionsResolver()->resolve($options);
        } catch (InvalidArgumentException $e) {
            // that didn't go well
            return $this->handleError($shortcode, $e);
        }

        // now render and return
        $handledShortcode = new HandledShortcode(
            $shortcode,
            $this->twig->render($this->getTemplatePrefix(), $options),
            $this->twig->render($this->getTemplateSuffix(), $options)
        );
        $this->adjustHandledShortcode($handledShortcode);
        return $handledShortcode;
    }

    /**
     * Allows changing the HandledShortcode just before returning it
     *
     * @param HandledShortcodeInterface $handledShortcode
     */
    protected function adjustHandledShortcode(HandledShortcodeInterface $handledShortcode)
    {
        // no action here
    }

    /**
     * Returns a HandledShortcode object for the situation the handling fails
     *
     * Fails are usually due to incorrect parameters
     *
     * @param ShortcodeInterface $shortcode
     * @param \Exception         $e
     *
     * @return HandledShortcode
     */
    protected function handleError(ShortcodeInterface $shortcode, \Exception $e)
    {
        return new HandledShortcode(
            $shortcode,
            '[' . $shortcode->getName() . ' error="' . $e->getMessage() . '"]',
            '[/' . $shortcode->getName() . ']',
            false
        );
    }

    /**
     * Prepares the parameters for rendering
     *
     * Note: the options will be pulled through the OptionsResolver after this
     *
     * @param ShortcodeInterface $shortcode
     *
     * @return array
     */
    protected function getOptions(ShortcodeInterface $shortcode)
    {
        // prepare parameters
        $options              = $shortcode->getParameters();
        $options['shortcode'] = $shortcode;

        // return this
        return $options;
    }


    /**
     * Should return the twig template to use for the prefix
     *
     * @return string
     */
    abstract protected function getTemplatePrefix();

    /**
     * Should return the twig template to use for the suffix
     *
     * @return string
     */
    abstract protected function getTemplateSuffix();

    /**
     * @return OptionsResolver
     */
    private function getOptionsResolver()
    {
        if (empty($this->_optionsResolver)) {
            $this->_optionsResolver = new OptionsResolver();
            $this->configureOptionsResolver($this->_optionsResolver);
        }
        return $this->_optionsResolver;
    }

    /**
     * Configures the OptionsResolver
     *
     * @param OptionsResolver $optionsResolver
     */
    protected function configureOptionsResolver(OptionsResolver $optionsResolver)
    {
        // pass the shortcode itself
        $optionsResolver->setDefault('shortcode', null);
        $optionsResolver->setAllowedTypes('shortcode', '\\Doppy\\Shortcode\\Shortcode\\ShortcodeInterface');
        $optionsResolver->setRequired('shortcode');
    }
}