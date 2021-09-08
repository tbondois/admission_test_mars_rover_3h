<?php


namespace App\Controller;

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Manager\ExplorationManager;
use App\Manager\ExplorationManagerInteface;


class ExplorationController extends AbstractController
{
    /**
     * @Route("/explore", methods="POST", name="exploration_post")
     */
    public function post(Request $request, ExplorationManager $explorationManager): JsonResponse
    {
        return $explorationManager->sendInstructions($request->getContent());
    }


} // end class
