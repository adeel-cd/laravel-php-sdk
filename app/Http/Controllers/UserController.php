<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Poc\Convo\ConvoUser;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @var ConvoUser
     */
    private $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user = new ConvoUser();
    }


    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username'    => 'required|email',
            'firstname'   => 'required',
            'lastname'    => 'required',
            'roles'       => 'required|array',
            'designation' => 'required',
            'image'     => 'required',
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

        $filename = $request->file('image')->getClientOriginalName();

        $path = Storage::disk('local')->put('user', $request->file('image'));

        $request->request->add([
            'picture'  => $filename
        ]);
        $request->request->add([
            'picturebase64' => base64_encode(Storage::disk('local')->get($path))
        ]);

        return response()->json(json_decode($this->user->createUser($request->all())));
    }
}
