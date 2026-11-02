<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendence;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_token' => 'nullable|string',
        ]);

        $user = StudentAttendence::where('username', $credentials['username'])->first();
        if (! $user || ! \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        if (! empty($credentials['device_token'])) {
            $user->update(['device_token' => $credentials['device_token']]);
        }

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function index()
    {
        $records = StudentAttendence::latest()->paginate(25);
        return response()->json($records);
    }

    public function store(Request $request)
    {
        $record = StudentAttendence::create($request->all());
        return response()->json($record, 201);
    }

    public function show(StudentAttendence $record)
    {
        return response()->json($record);
    }

    public function update(Request $request, StudentAttendence $record)
    {
        $record->update($request->all());
        return response()->json($record);
    }

    public function destroy(StudentAttendence $record)
    {
        $record->delete();
        return response()->json(null, 204);
    }
}
