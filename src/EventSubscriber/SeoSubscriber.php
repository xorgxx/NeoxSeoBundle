<?php
    /**
     * integration of Seo dynamique in all the page
     * requirements :
     *        - c req "leogout/seo-bundle"
     *
     * In your controller  !!
     *        if you want to add dynamique Seo on you "Action" you need to follow this rule NAME :
     *            - #[Route('/', name: [NAME])] ---> NAME = [seo]_[name domain] xxxxx = "seo_home_xxxx_xxxxx_xxx
     *
     * them in folder translations :
     *    home.fr.yml
     *        home:
     *            seo:
     *                title: 'Xorg Bienvenue | Creation de site web, mobile, application station'
     *                description: |
     *                    Xorg est une agence digitale fondée en 2010. Design, UX, Développement web et
     *                    Référencement SEO sur mesure.
     *                image: '%web_site%/images/logo/logoWhite.png'
     *
     * So with this code in subscriber it will add only if you have in the domain, on top off this you can still make any change
     * directly in your controller. last if there is none in home.fr.yml and none in controller then it will give the default one
     * from leogout/seo-bundle
     *
     * ps : i get the TranslatorInterface form my controller so i dont need to make __construct methode
     *    be free to add !!
     *    for the App\Services\SeoService thank to ask for.
     *
     */
    
    namespace NeoxSeo\NeoxSeoBundle\EventSubscriber;
    
    
    use NeoxSeo\NeoxSeoBundle\Pattern\NeoxSeoService;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
    use Symfony\Component\HttpKernel\Event\ControllerEvent;
    use Symfony\Component\HttpKernel\HttpKernelInterface;
    use Symfony\Component\HttpKernel\KernelEvents;
    
    class SeoSubscriber implements EventSubscriberInterface
    {
        public function __construct(private readonly NeoxSeoService $neoxSeoService)
        {
        }
        
        /**
         * @throws \ReflectionException
         */
        public function onKernelController(ControllerArgumentsEvent $event): void
        {
            if (HttpKernelInterface::MAIN_REQUEST !== $event->getRequestType()) {
                // don't do anything if it's not the master request
                return;
            }
            // Il s'agit de la requête principale
            $controller = $event->getRequest()->attributes->get('_controller');
            if (!$this->isProfilerController($controller)) {
                $this->neoxSeoService->init();
            }
        }
        private function isProfilerController($controller): bool
        {
            return str_starts_with($controller, 'web_profiler.controller.profiler::');
        }
        
        public static function getSubscribedEvents(): array
        {
            return [
                KernelEvents::CONTROLLER_ARGUMENTS => 'onKernelController',
            ];
        }
    }