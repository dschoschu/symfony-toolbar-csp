<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CspSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['checkContentSecurityPolicies']
        ];
    }

    /**
     * Ensures if the Content-Security-Policy header are set
     *
     * @param FilterResponseEvent $event
     */
    public function checkContentSecurityPolicies(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response->headers->has('Content-Security-Policy')) {
            return;
        }

        $response->headers->set('Content-Security-Policy', 'default-src \'self\'; script-src \'self\' \'unsafe-eval\'; img-src \'self\' data:');
        $response->headers->set('X-Content-Security-Policy', 'default-src \'self\'; script-src \'self\' \'unsafe-eval\'; img-src \'self\' data:');
    }
}
