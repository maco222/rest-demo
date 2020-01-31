<?php

namespace App\Controller;

use App\Document\Task;
use App\Form\TaskType;
use App\Manager\TaskManager;
use Doctrine\ODM\MongoDB\Iterator\CachingIterator;
use Doctrine\ODM\MongoDB\Query\Builder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Knp\Component\Pager\PaginatorInterface;
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
    /** @var TaskManager */
    protected $manager;

    /** @var PaginatorInterface */
    protected $paginator;

    /**
     * TaskController constructor.
     * @param TaskManager $manager
     */
    public function __construct(TaskManager $manager, PaginatorInterface $paginator)
    {
        $this->manager = $manager;
        $this->paginator = $paginator;
    }

    /**
     * List of all tasks
     * @Rest\QueryParam(name="sort", requirements="(title|created_at|is_done)", default="created_at", description="Field name to sort the results by, default: created_at")
     * @Rest\QueryParam(name="sortDir", requirements="(asc|desc)", default="desc", description="Sorting direction, default: desc")
     * @Rest\QueryParam(name="pagination", requirements="(0|1)", default="1", description="Specifies if the pagination is enabled, default: 1")
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Number of the page to show, default: 1")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="2", description="Number of tasks to show on one page, default: 10")
     * @SWG\Response(
     *     response=200,
     *     description="Array of Task objects",
     *     @Model(type=App\Document\Task::class)
     * )
     * @return \FOS\RestBundle\View\View
     */
    public function getTasksAction(ParamFetcher $paramFetcher)
    {
        $sort = $paramFetcher->get('sort');
        $sortDir = $paramFetcher->get('sortDir');

        if($paramFetcher->get('pagination')) {
            $page = $paramFetcher->get('page');
            $limit = $paramFetcher->get('limit');

            $tasksQueryBuilder = $this->manager->getAllQueryBuilder($sort, $sortDir);
            $tasksPagination = $this->paginator->paginate($tasksQueryBuilder, $page, $limit);

            $pages = ceil($tasksPagination->getTotalItemCount()/ $limit);
            $collection = new CollectionRepresentation($tasksPagination);
            $paginated = new PaginatedRepresentation(
                $collection,
                "get_tasks",
                array(),
                $page,
                $limit,
                $pages
            );

            return $this->view($paginated, Response::HTTP_OK);
        }
        $tasks = $this->manager->getAll($sort, $sortDir);
        return $this->view($tasks, Response::HTTP_OK);
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
