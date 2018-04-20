<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberServiceTest extends TestCase
{
    /**
     * Doit ajouter un nouvel email en base de donnée
     * Doit aussi vérifier qu'un email est en cours d'envoi dans le gestionnaire de queue
     *
     * 2 Points
     */
    public function testCreateEmail_Success_NominalCase()
    {
        // Arrange
        $email = 'First email';

        // Assert
        $this->emailMocked->shouldReceive('where')
            ->once()
            ->with([
                Email::EMAIL => $email
            ])
            ->andReturn($this->taskMocked);

        $this->emailMocked->shouldReceive('first')
            ->once()
            ->andReturnNull();


        $this->emailMocked->shouldReceive('create')
            ->once()
            ->with([
                Email::EMAIL => $email
            ])
            ->andReturnTrue();

        $emailService = new EmailService($this->emailMocked);

        // Act
        $emailService->create($email);
    }






    /**
     * Doit retourner une exception de type EmailAlreadyExistException
     * si l'email est déjà existant
     *
     * 2 Points
     */

    public function testEmailAlreadyExistException()
    {
        // Arrange
        $task = 'First task';

        // SELECT name FROM tasks WHERE name = 'First task' LIMIT 1;
        $this->taskMocked->shouldReceive('where')
            ->once()
            ->with([
                Task::NAME => $task
            ])
            ->andReturn($this->taskMocked);

        $this->taskMocked->shouldReceive('first')
            ->once()
            ->andReturn(new Task());

        $this->taskMocked->shouldReceive('create')
            ->times(0);

        $taskService = new TaskService($this->taskMocked);

        // Assert
        $this->expectException(TaskAlreadyExistException::class);

        // Act
        $taskService->create($task);
    }

}
