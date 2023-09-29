<?php
    
    namespace NeoxSeo\NeoxSeoBundle\Pattern;

    use NeoxSeo\NeoxSeoBundle\Model\SeoBag;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    
    abstract class NeoxSeoAbstract
    {
        public SeoBag $seoBag;
        public ParameterBagInterface $parameterBag;
        
        public function __construct(ParameterBagInterface $parameterBag, SeoBag $seoBag){
            $this->parameterBag = $parameterBag;
            $this->seoBag       = $seoBag;
        }
        
        public function init(): seoBag
        {
            // Get the SEO configuration
            $seo = $this->parameterBag->get('neox_seo.seo');
            if ($this->seoBag->getTitle() === "ko") {
                $this->seoBag = new seoBag();
                $this->seoBag
                    ->setTitle($seo['title'] ?? null)
                    ->setCharset($seo['charset'] ?? null)
                    ->setMetasHttpEquiv($seo["metas"]['metasHttpEquiv'] ?? null)
                    ->setMetasName($seo["metas"]['metasName'] ?? null)
                    ->setMetasProperty($seo["metas"]['metasProperty'] ?? null)
                    ->setMetasItemprop($seo["metas"]['metasItemprop'] ?? null);
            }
            return $this->seoBag;
        }

    }