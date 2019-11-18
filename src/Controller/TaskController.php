<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use App\Security\Voter\TaskVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tasks")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_new")
     */
    public function new(Request $request)
    {
        // just setup a fresh $task object
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task, [
            'require_due_date' => true,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $task->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_edit', ['id' => $task->getId()]);
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_edit")
     */
    public function edit(Task $task, Request $request)
    {
        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);

        $form = $this->createForm(TaskType::class, $task, [
            'require_due_date' => true,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'taskUser' => $task->getUser()
        ]);
    }
}
