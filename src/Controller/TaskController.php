<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TaskController
 * @package App\Controller
 */
class TaskController extends AbstractController
{
    /**
     * @Rest\Route(path="/api/task", name="task_list")
     */
    public function list()
    {
        return new JsonResponse(["success" => true]);
    }
}

