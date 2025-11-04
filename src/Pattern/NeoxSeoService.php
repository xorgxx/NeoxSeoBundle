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
        private array $seoParams    = [];
        public ?SeoBag $seoBag      = null;
        private ?string $controller = null;
        private ?string $action     = null;
        
        public function __construct(private readonly RequestStack $requestStack, private readonly ParameterBagInterface $parameterBag)
        {
        
        }
        
        public function getSeoBag(): SeoBag
        {
            if (!$this->seoBag) {
                $this->setNeoxSeo();
                $this->setUriCanonical();
            }
            return $this->seoBag;
        }
        
        public function setNeoxSeo(): SeoBag
        {
            // first apply seo settings from configuration
            $this->setSeoParams();
            
            // then apply the controller and method attributes
            $attributes = $this->getAttributesFromControllerAndMethod();
            foreach ($attributes as $attribute) {
                $data = $attribute->newInstance();
                foreach ($data as $key => $value) {
                    if ($value) {
                        $setter = "set" . $key;
                        $this->seoBag->$setter($value);
                    }
                }
            }
            return $this->seoBag;
        }
        
        private function setSeoParams(): void
        {
            $this->seoBag           = new SeoBag();
            $this->seoParams        = $this->parameterBag->get('neox_seo.seo');
            $this->seoBag
                ->setTitle($this->seoParams ['title'] ?? null)
                ->setCharset($this->seoParams ['charset'] ?? null)
                ->setLink($this->seoParams ['link'] ?? [])
                ->setHtml($this->seoParams ['html'] ?? [])
                ->setMetasHttpEquiv($this->seoParams ['metas']['metasHttpEquiv'] ?? [])
                ->setMetasName($this->seoParams ['metas']['metasName'] ?? [])
                ->setMetasProperty($this->seoParams ['metas']['metasProperty'] ?? [])
                ->setMetasItemprop($this->seoParams ['metas']['metasItemprop'] ?? []);
        }
        
        private function setUriCanonical(): void
        {
            if (isset($this->seoParams["link"]["canonical"]) && $this->seoParams["link"]["canonical"] === "auto") {
                $uri = $this->requestStack->getCurrentRequest()->getUri();
                $this->seoBag->setLink(['canonical' => "href='$uri'"]);
            }
            
        }
//        private function getAttributesFromControllerAndMethod(): array
//        {
//            $this->getInfoAboutCurrentRequest();
//            $classAttributes    = (new ReflectionClass($this->controller))->getAttributes(NeoxSeo::class);
//            $methodAttributes   = (new ReflectionMethod($this->controller, $this->action))->getAttributes(NeoxSeo::class);
//            return array_merge($classAttributes, $methodAttributes);
//        }

        private function getAttributesFromControllerAndMethod(): array
        {
            $this->getInfoAboutCurrentRequest();

            if (!$this->controller || !$this->action) {
                return [];
            }

            try {
                $classAttributes = (new ReflectionClass($this->controller))->getAttributes(NeoxSeo::class);
                $methodAttributes = (new ReflectionMethod($this->controller, $this->action))->getAttributes(NeoxSeo::class);

                return array_merge($classAttributes, $methodAttributes);
            } catch (\ReflectionException $e) {
                // Log ou gérer l'erreur
                return [];
            }
        }

        private function getInfoAboutCurrentRequest(): void
        {
            $request = $this->requestStack->getCurrentRequest();

            if ($request) {
                $controllerName = $request->attributes->get('_controller');

                if (is_string($controllerName) && strpos($controllerName, '::') !== false) {
                    list($this->controller, $this->action) = explode('::', $controllerName);
                } else {
                    // Gère les cas où le contrôleur est invalide
                    $this->controller = null;
                    $this->action = null;
                }
            }
        }
//        private function getInfoAboutCurrentRequest(): void
//        {
//            $request = $this->requestStack->getCurrentRequest();
//
//            if ($request) {
//                $controllerName = $request->attributes->get('_controller');
//                list($this->controller, $this->action) = explode('::', $controllerName);
//            }
//        }
    }