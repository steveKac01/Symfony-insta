<?php

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener extends AbstractController
{
    public function __construct(private Environment $twig)
    {
    }

    /**
     * Errors handler.
     * Redirects the user on 404 and 403 errors.
     *
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        switch (true) {
            case $exception instanceof NotFoundHttpException:
                $content = $this->twig->render('exceptions/not_found.html.twig');
                $event->setResponse((new Response())->setContent($content));
                break;
                
            case $exception instanceof AccessDeniedHttpException:
                $content = $this->twig->render('exceptions/forbidden.html.twig');
                $event->setResponse((new Response())->setContent($content));
                break;
        }

        return;
    }
}
