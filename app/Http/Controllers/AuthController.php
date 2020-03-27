<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Poc\Convo\ConvoAuth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{

    /**
     * @var ConvoAuth
     */
    private $auth;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->auth = new ConvoAuth();
    }

    /**
     * Authenticate User
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse|mixed|\Psr\Http\Message\StreamInterface
     */
    public function auth(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'username' => 'required|email',
            'password' => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json([
                'status' => 419,
                'messages' => [
                    $validate->errors()->all()
                ]
            ], 419);
        }

        return response()->json(json_decode($this->auth->authenticateUser($request->all())));
    }
}
