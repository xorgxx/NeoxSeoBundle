<?php
    
    namespace NeoxSeo\NeoxSeoBundle\Pattern;
    
    use NeoxSeo\NeoxSeoBundle\Model\SeoBag;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\HttpFoundation\RequestStack;
    
    /**
     *
     *
     */
    class NeoxSeoFactory
    {
        public ParameterBagInterface $parameterBag;
        private RequestStack $requestStack;
        private NeoxSeoService $seoService;
        
        public function __construct(ParameterBagInterface $parameterBag, RequestStack $requestStack, NeoxSeoService $seoService)
        {
            $this->parameterBag = $parameterBag;
            $this->requestStack = $requestStack;
            $this->seoService   = $seoService;
        }
        
        public function getSeoService(): NeoxSeoService
        {
            return $this->seoService;
        }
        
        
        public function setSeoService(): NeoxSeoService
        {
            return new NeoxSeoService($this->requestStack, $this->parameterBag);
        }
    }