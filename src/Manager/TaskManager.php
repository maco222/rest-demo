<?php

namespace App\Manager;

use App\Document\Task;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Query;
use Doctrine\Persistence\ObjectRepository;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class TaskManager
{
    /** @var DocumentManager */
    protected $dm;

    /** @var ObjectRepository */
    protected $repository;

    /**
     * TaskManager constructor.
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        $this->repository = $this->dm->getRepository(Task::class);
    }

    public function getAllQueryBuilder($sort = "created_at", $sortDir = "desc")
    {
        /** @var Query $query */
        $query = $this->dm->createQueryBuilder(Task::class)
            ->sort($sort, $sortDir);

        return $query;
    }

    public function getAll($sort = "created_at", $sortDir = "desc")
    {
        $tasks = $this->getAllQueryBuilder($sort, $sortDir)->getQuery()->execute();
        return $tasks;
    }

    public function get(string $id)
    {
        return $this->repository->find($id);
    }

    public function search()
    {

    }
}
