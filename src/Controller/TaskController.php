<?php

namespace App\Controller;

use App\Document\Task;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TaskController
 */
class TaskController extends AbstractFOSRestController
{
    /** @var DocumentRepository */
    protected $repository;

    /**
     * TaskController constructor.
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->repository = $dm->getRepository(Task::class);
    }

    /**
     * @return \FOS\RestBundle\View\View
     */
    public function getTasksAction()
    {
        $data = $this->repository->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return \FOS\RestBundle\View\View
     */
    public function getTaskAction(string $id)
    {
        $data = $this->repository->findOneBy(["id" => $id]);
        return $this->view($data, $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    public function postTaskAction()
    {
    }

    public function putTaskAction()
    {
    }
}
