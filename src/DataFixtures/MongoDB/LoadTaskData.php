<?php

namespace App\DataFixtures\MongoDB;

use App\Document\Task;
use Doctrine\Bundle\MongoDBBundle\Fixture\ODMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadTaskData implements ODMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = Yaml::parse(file_get_contents(__DIR__."/data.yaml"));
        foreach ($data["data"]["task"] as $taskEntry) {
            $task = new Task();
            $task->setTitle($taskEntry['title']);
            $task->setContent($taskEntry['content']);
            $manager->persist($task);
        }
        $manager->flush();
    }
}