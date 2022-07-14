<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ApplicatesResource;
use App\Http\Resources\UserResource;
use App\Models\ProjectOffer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(StoreUserRequest $request): JsonResponse
    {
        $data = $request->except(['password_confirmation', 'type']);
        $data['email_verified_at'] = now();
        $user = User::create($data);
        $request->type === User::POSTER_ROLE
            ? $user->assignRole(User::POSTER_ROLE)
            : $user->assignRole(User::TASKER_ROLE);

        event(new Registered($user));

        return response()->json([
            'success' => true,
            'user' => '',
            'message' => 'Your account created successfully.'
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        $user->update($data);
        $user->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Your account was updated successfully.',
            'user' => $user
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email:filter',
            'password' => 'required:min:8',
        ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorect.'
            ], 401);
        }

        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Before proceeding, please check your email for a verification link'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleName(),
            ]
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(['success' => true]);
    }

    public function updatePassword(ChangePasswordRequest $request, User $user)
    {
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response([], 200);
    }

    public function getStudentUsers()
    {
        $users = User::query()->role(User::TASKER_ROLE)->get();
        return UserResource::collection($users);
    }

    public function show($userId)
    {
        $user = User::query()->where('id', $userId)->role(User::TASKER_ROLE)->get()->first();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'department' => $user->department,
                'role' => $user->getRoleName(),

            ]
        ]);
    }

    public function applicates($userId)
    {
        $applicates = ProjectOffer::query()->with(['user', 'project'])
            ->where('user_id', $userId)
            ->where('status', 1)
            ->get();

        return response()->json(ApplicatesResource::collection($applicates));
    }
}
