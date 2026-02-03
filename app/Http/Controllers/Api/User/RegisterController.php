<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Register\CodeRequest;
use App\Http\Requests\Api\User\Register\OtpRequest;
use App\Http\Requests\Api\User\Register\RegisterRequest;
use App\Http\Resources\User\RegisterResource;
use App\Services\Api\User\RegisterService;
use App\Traits\HttpResponse;

class RegisterController extends Controller
{
    use HttpResponse;
    public function __construct(public RegisterService $registerService) {}

    public function register(RegisterRequest $request)
    {
        $data = $this->registerService->register($request->validated());
        if ($data instanceof \Illuminate\Http\JsonResponse) {
            return $data;
        }

        $resource = [
            'user' => new RegisterResource($data),
            'otp'  => $data['code'],
        ];
        return $this->okResponse($resource, __('User registered successfully', [], Request()->header('Accept-language')));
    }

    public function verify(CodeRequest $codeRequest)
    {
        [$user, $token] = $this->registerService->verify($codeRequest->validated());

        $response = [
            'user'  => RegisterResource::make($user),
            'token' => $token,
        ];
        return $this->okResponse($response, __('User account verified successfully', [], request()->header('Accept-language')));
    }

    public function otp(OtpRequest $request)
    {
        $data = $this->registerService->otp($request->validated());

        $resource = [
            'user' => new RegisterResource($data),
            'otp'  => $data['code'],
        ];
        return $this->okResponse($resource, __('Otp updated successfully', [], Request()->header('Accept-language')));
    }
}
