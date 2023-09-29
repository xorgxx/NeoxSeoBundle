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
        public ParameterBagInterface   $parameterBag;
        private RequestStack $requestStack;
        
        public function __construct( ParameterBagInterface $parameterBag, RequestStack $requestStack )
        {
            $this->parameterBag         = $parameterBag;
            $this->requestStack         = $requestStack;
        }
        
        
        /**
         * @throws \ReflectionException
         */public function SeoStrategy(): NeoxSeoService
        {
            return new NeoxSeoService($this->requestStack, $this->parameterBag);
        }
    }