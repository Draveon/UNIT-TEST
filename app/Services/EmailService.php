<?php

namespace App\Services;

use App\Exceptions\EmailAlreadyExistException;
use App\Exceptions\EmailNotFoundException;
use App\Models\Eamil;
use Illuminate\Database\Eloquent\Collection;

class EmailService
{
    /**
     * @var Email
     */
    private $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Permet la récupération des tâches de la TODO
     *
     * @return Collection
     * @throws \Exception
     */
    public function lists(): Collection
    {
        return $this->email->all();
    }

    /**
     * Permet de créer une nouvelle tâches à la TODO
     *
     * @param string $name
     * @throws \Exception
     */
    public function create(string $email)
    {
        // $taskMocked
        $result = $this->email->where([
            Email::EMAIL => $email
        ])->first();

        if (!is_null($result)) {
            throw new EmailAlreadyExistException();
        }

        $this->email->create([
            Email::EMAIL => $email
        ]);
    }

    /**
     * Permet la mise à jour d'une tâche de la TODO
     *
     * @param int $id
     * @param string $name
     * @throws \Exception
     */
    public function update(int $id, string $name)
    {

        $emailNotFoundResult = $this->email->where([
            'id' => $id
        ])->first();

        // Si l'id n'existe pas
        if (is_null($emailNotFoundResult)) {
            throw new EmailNotFoundException();
        }

        $emailFound = $this->email->where([
            Email::EMAIL => $email
        ])->first();

        // Si on trouve déjà un tâche à ce nom...
        if ($emailFound['id'] !== $id) {
            throw new EmailAlreadyExistException();
        }

        $this->email->where([
            'id' => $id
        ])->update([
            Email::EMAIL => $email
        ]);
    }

    /**
     * Permet la suppression d'une tâches par son ID
     *
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id)
    {
        // Je vérifie que ça existe
        $email = $this->email->where([
            'id' => $id
        ])->first();

        if (is_null($email)) {
            throw new EmailNotFoundException();
        }

        // Après je supprime
        $this->email->where([
            'id' => $id
        ])->delete();
    }
}