<?php

namespace NeoxSeo\NeoxSeoBundle\Twig;

use Leogout\Bundle\SeoBundle\Model\RenderableInterface;
use NeoxSeo\NeoxSeoBundle\Attribute\NeoxSeo;
use NeoxSeo\NeoxSeoBundle\Pattern\NeoxSeoService;
use ReflectionException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NeoxSeoExtension extends AbstractExtension
{
    private neoxSeoService $neoxSeoService;
    
    /**
     * @throws ReflectionException
     */
    public function __construct(NeoxSeoService $neoxSeoService)
    {
        // Inject dependencies if needed
        $this->neoxSeoService = $neoxSeoService;
    }
    
    /**
     *      <html {{ neox_seo_html_attributes() }}>
     *      <head {{ neox_seo_head_attributes() }}>
     *          {{ neox_seo_title() }}
     *          {{ neox_seo_metadata() }}
     *          {{ neox_seo_link_canonical() }}
     *          {{ neox_seo_lang_alternates() }}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('neoxSeoHtmlAttributes', [$this, 'neoxSeoHtmlAttributes'], ['is_safe' => ['html']]),
            new TwigFunction('neoxSeoTitle', [$this, 'neoxSeoTitle'], ['is_safe' => ['html']]),
            new TwigFunction('neoxSeoMetadata', [$this, 'neoxSeoMetadata'], ['is_safe' => ['html']]),
            new TwigFunction('neoxSeoItemprop', [$this, 'neoxSeoItemprop'], ['is_safe' => ['html']]),
            new TwigFunction('neoxSeoHttpEquiv', [$this, 'neoxSeoHttpEquiv'], ['is_safe' => ['html']]),
            new TwigFunction('neoxSeoLink', [$this, 'neoxSeoLink'], ['is_safe' => ['html']]),
        ];
    }
    public function neoxSeoHtmlAttributes(): string
    {
        return implode(" ", $this->neoxSeoService->getSeoBag()->getHtml());
    }
    
    public function neoxSeoTitle(): string
    {
        return $this->neoxSeoService->getSeoBag()->getTitle();
    }
    
    public function neoxSeoName(): string
    {
        return implode(PHP_EOL."\t\t", $this->neoxSeoService->getSeoBag()->getMetasName());
    }
    
    public function neoxSeoMetadata(): string
    {
        return implode(PHP_EOL."\t\t", $this->neoxSeoService->getSeoBag()->getAllMetas());
    }
    
    public function neoxSeoHttpEquiv(): string
    {
        return implode(PHP_EOL."\t\t", $this->neoxSeoService->getSeoBag()->getMetasHttpEquiv());
    }
    
    public function neoxSeoItemprop(): string
    {
        return implode(PHP_EOL."\t\t", $this->neoxSeoService->getSeoBag()->getMetasItemprop());
    }
    
    public function neoxSeoLink(): string
    {
        return implode(PHP_EOL."\t\t", $this->neoxSeoService->getSeoBag()->getLink());
    }
}