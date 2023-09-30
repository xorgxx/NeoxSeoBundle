<?php
    
    namespace NeoxSeo\NeoxSeoBundle\Pattern;
    
    use NeoxSeo\NeoxSeoBundle\Attribute\NeoxSeo;
    use NeoxSeo\NeoxSeoBundle\Model\SeoBag;
    use ReflectionClass;
    use ReflectionMethod;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\HttpFoundation\RequestStack;
    
    class NeoxSeoService
    {
        public ?SeoBag $seoBag = null;
        private string $controller;
        private string $action;
     
        
        public function __construct(private readonly RequestStack $requestStack, private readonly ParameterBagInterface $parameterBag)
        {
       
        }
        
        public function setNeoxSeo(): SeoBag
        {
            
            
            $attributes = $this->getAttributesFromControllerAndMethod();
            
            foreach ($attributes as $attribute) {
                foreach ($attribute->newInstance() as $key => $value) {
                    if ($value) {
                        $setter = "set" . $key;
                        $this->seoBag->$setter($value);
                    }
                }
            }
            return $this->seoBag;
        }
        
        public function getSeoBag(): SeoBag
        {
            return $this->seoBag;
        }
        
        public function init(): seoBag
        {
            // Get the SEO configuration
            $seo = $this->parameterBag->get('neox_seo.seo');
            if (!$this->seoBag) {
                $this->seoBag = new seoBag();
                $this->seoBag
                    ->setTitle($seo['title'] ?? null)
                    ->setCharset($seo['charset'] ?? null)
                    ->setLink($seo['link'] ?? [])
                    ->setHtml($seo['html'] ?? [])
                    ->setMetasHttpEquiv($seo["metas"]['metasHttpEquiv'] ?? [])
                    ->setMetasName($seo["metas"]['metasName'] ?? [])
                    ->setMetasProperty($seo["metas"]['metasProperty'] ?? [])
                    ->setMetasItemprop($seo["metas"]['metasItemprop'] ?? []);
            }
            
            $this->setNeoxSeo();
            
            return $this->seoBag;
        }
        
        private function getAttributesFromControllerAndMethod(): array
        {
            $this->getInfoAboutCurrentRequest();
            $classAttributes = (new ReflectionClass($this->controller))->getAttributes(NeoxSeo::class);
            $methodAttributes = (new ReflectionMethod($this->controller, $this->action))->getAttributes(NeoxSeo::class);
            
            return array_merge($classAttributes, $methodAttributes);
        }
        
        private function getInfoAboutCurrentRequest(): void
        {
            $request = $this->requestStack->getCurrentRequest();
            
            if ($request) {
                $controllerName = $request->attributes->get('_controller');
                list($this->controller, $this->action) = explode('::', $controllerName);
            }
        }
    }