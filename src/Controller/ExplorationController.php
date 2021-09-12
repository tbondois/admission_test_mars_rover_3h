<?php

namespace App\Controller;

namespace App\Controller;

use App\Service\MissionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExplorationController extends AbstractController
{
    /**
     * @Route("/explore", methods="POST", name="exploration_post")
     */
    public function post(Request $request, MissionServiceInterface $missionService): Response
    {
        try {
            $mission = $missionService->runInput($request->getContent());
            return new Response($mission->serialize());
        } catch (\RangeException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
