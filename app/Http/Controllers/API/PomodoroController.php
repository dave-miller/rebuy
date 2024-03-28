<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PomodoroController extends Controller
{
    #[OA\Get(
        path: '/api/pomodoros',
        description: 'return a list of pomodoros timers',
        tags: ['pomodoros'],
        responses: [
            new OA\Response(response: 200, description: 'AOK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function index(Request $request)
    {
        $pomodoros = $request->user()->pomodoros()->get();

        return response()->json($pomodoros);
    }

    #[OA\Get(
        path: '/api/pomodoros/{uuid}',
        description: 'return a pomodoros timer based on uuid',
        tags: ['pomodoros'],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                description: 'Find pomodoro by uuid',
                required: false,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'AOK'),
            new OA\Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function show(Request $request, $uuid)
    {
        try {
            // Retrieve a specific Pomodoro by its UUID for the authenticated user
            $pomodoro = $request->user()->pomodoros()->where('uuid', $uuid)->firstOrFail();

            return response()->json($pomodoro);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Pomodoro not found.'], 404);
        }
    }
}
