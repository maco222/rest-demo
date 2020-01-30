<?php

namespace App\Controller;

use App\Document\Task;
use App\Form\TaskType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class TaskController
 * @SWG\Tag(name="tasks")
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
     * List of all tasks
     * @SWG\Response(
     *     response=200,
     *     description="Array of Task objects",
     *     @Model(type=App\Document\Task::class)
     * )
     * @return \FOS\RestBundle\View\View
     */
    public function getTasksAction()
    {
        $data = $this->repository->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Single Task by its id
     *
     * @SWG\Response(
     *     response=200,
     *     description="Single Task object",
     *     @Model(type=App\Document\Task::class)
     * )
     *
     * @param string $id
     * @return \FOS\RestBundle\View\View
     */
    public function getTaskAction(string $id)
    {
        $data = $this->repository->findOneBy(["id" => $id]);
        return $this->view($data, $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * New Task
     *
     * @SWG\Response(
     *     response=200,
     *     description="Single Task object",
     *     @Model(type=App\Document\Task::class)
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function postTaskAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid()) {
            $this->repository->getDocumentManager()->persist($task);
            $this->repository->getDocumentManager()->flush();
            return $this->view($task, Response::HTTP_OK);
        }
        return $form;
    }

    /**
     * Modify Task
     *
     * @SWG\Response(
     *     response=200,
     *     description="Single Task object",
     *     @Model(type=App\Document\Task::class)
     * )
     */
    public function putTaskAction()
    {
    }
}
