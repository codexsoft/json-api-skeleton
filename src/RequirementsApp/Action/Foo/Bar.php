<?php

namespace RequirementsApp\Action\Foo;

use CodexSoft\JsonApi\DocumentedFormAction;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Bar extends DocumentedFormAction
{

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/foo/bar", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(): Response
    {
        $data = $this->getJsonData();
        if ($data instanceof Response) { return $data; }
        if ($this->isResponseExampleRequested()) { return $this->generateResponseExample(); }
        
        return new BarResponse([
            'id' => 42,
        ]);
    }

    public static function producesResponses(): array
    {
        return parent::producesResponses();
        //return [
        //    200 => (new ResponseDoc)->formClass
        //];
    }

}