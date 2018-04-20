<?php

namespace App\Http\Controllers;

use App\Exceptions\EmailAlreadyExistException;
use App\Models\Email;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    /**
     * @var EmailService
     */
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Il faut retourner à la vue un liste tâches
     */
    public function index()
    {
        return view('email.index');
    }

    public function create(Request $request)
    {
        $values = $request->only([
            Email::NAME
        ]);

        $validator = Validator::make($values, [
            Email::NAME => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->action('EmailController@index')
                ->with('alert', [
                    'message' => 'require_fields',
                    'type' => 'warning'
                ]);
        }

        try {
            $this->emailService->create($values[Email::NAME]);
        } catch (EmailAlreadyExistException $e) {
            return redirect()->action('EmailController@index')
                ->with('alert', [
                    'message' => 'already_exist',
                    'type' => 'warning'
                ]);
        }

        return redirect()->action('EmailController@index')
            ->with('alert', [
                'message' => 'success_message',
                'type' => 'success'
            ]);
    }

    public function update()
    {

    }

    public function delete($id)
    {

    }
}
