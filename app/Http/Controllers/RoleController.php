<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Poc\Convo\ConvoRole;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{

    /**
     * @var ConvoRole
     */
    private $role;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->role = new ConvoRole();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listRole(Request $request)
    {
        $validate = Validator::make($request->all(), [
            '_token' => 'required'
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

        return response()->json(json_decode($this->role->listAllRoles($request->all())));
    }
}
