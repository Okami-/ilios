<?php

namespace Ilios\CoreBundle\Handler;

use Ilios\CoreBundle\Entity\UserInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Ilios\CoreBundle\Exception\InvalidFormException;
use Ilios\CoreBundle\Form\Type\PublishEventType;
use Ilios\CoreBundle\Entity\Manager\PublishEventManager;
use Ilios\CoreBundle\Entity\PublishEventInterface;

/**
 * Class PublishEventHandler
 * @package Ilios\CoreBundle\Handler
 *
 * @deprecated
 */
class PublishEventHandler extends PublishEventManager
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @param Registry $em
     * @param string $class
     * @param FormFactoryInterface $formFactory
     * @param Request $request
     */
    public function __construct(Registry $em, $class, FormFactoryInterface $formFactory, Request $request)
    {
        $this->formFactory = $formFactory;
        parent::__construct($em, $class, $request);
    }

    /**
     * @param array $parameters
     * @param Request $request
     * @param UserInterface $user
     *
     * @return PublishEventInterface
     */
    public function post(array $parameters, Request $request, UserInterface $user)
    {
        $publishEvent = $this->createPublishEvent();

        $publishEvent->setMachineIp($request->getClientIp());
        $publishEvent->setAdministrator($user);

        $event =  $this->processForm($publishEvent, $parameters, 'POST');



        return $event;
    }

    /**
     * @param PublishEventInterface $publishEvent
     * @param array $parameters
     *
     * @return PublishEventInterface
     */
    public function put(
        PublishEventInterface $publishEvent,
        array $parameters
    ) {
        return $this->processForm(
            $publishEvent,
            $parameters,
            'PUT'
        );
    }

    /**
     * @param PublishEventInterface $publishEvent
     * @param array $parameters
     *
     * @return PublishEventInterface
     */
    public function patch(
        PublishEventInterface $publishEvent,
        array $parameters
    ) {
        return $this->processForm(
            $publishEvent,
            $parameters,
            'PATCH'
        );
    }

    /**
     * @param PublishEventInterface $publishEvent
     * @param array $parameters
     * @param string $method
     * @throws InvalidFormException when invalid form data is passed in.
     *
     * @return PublishEventInterface
     */
    protected function processForm(
        PublishEventInterface $publishEvent,
        array $parameters,
        $method = "PUT"
    ) {
        $form = $this->formFactory->create(
            new PublishEventType(),
            $publishEvent,
            array('method' => $method)
        );

        $form->submit($parameters, 'PATCH' !== $method);

        if (! $form->isValid()) {
            throw new InvalidFormException('Invalid submitted data', $form);
        }

        return $form->getData();
    }
}
