<?PHP

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/login',
        description: 'Authenticate user and generate authentication token',
        tags: ['Authentication'],
        summary: 'Authenticate user and generate authentication token',
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
}
