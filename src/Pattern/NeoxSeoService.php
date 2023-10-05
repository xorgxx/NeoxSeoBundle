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
        private array $seoParams = [];
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
            if (!$this->seoBag) {
                $this->init();
            }
            return $this->seoBag;
        }
        
        public function init(): seoBag
        {
            // Get the SEO configuration
            $this->seoParams = $this->parameterBag->get('neox_seo.seo');
            if (!$this->seoBag) {
                $this->seoBag = new seoBag();
                $this->seoBag
                    ->setTitle($this->seoParams['title'] ?? null)
                    ->setCharset($this->seoParams['charset'] ?? null)
                    ->setLink($this->seoParams['link'] ?? [])
                    ->setHtml($this->seoParams['html'] ?? [])
                    ->setMetasHttpEquiv($this->seoParams["metas"]['metasHttpEquiv'] ?? [])
                    ->setMetasName($this->seoParams["metas"]['metasName'] ?? [])
                    ->setMetasProperty($this->seoParams["metas"]['metasProperty'] ?? [])
                    ->setMetasItemprop($this->seoParams["metas"]['metasItemprop'] ?? []);
            }
            
            $this->setNeoxSeo();
            $this->setUriCanonical();
            
            return $this->seoBag;
        }
        
        private function setUriCanonical(): void
        {
            if ($this->seoParams["link"]["canonical"] === "auto") {
                $uri                = $this->requestStack->getCurrentRequest()->getUri();
                $this->seoBag->setLink(['canonical' => "href='$uri'"]);
            }
            
        }
        private function getAttributesFromControllerAndMethod(): array
        {
            $this->getInfoAboutCurrentRequest();
            $classAttributes    = (new ReflectionClass($this->controller))->getAttributes(NeoxSeo::class);
            $methodAttributes   = (new ReflectionMethod($this->controller, $this->action))->getAttributes(NeoxSeo::class);
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