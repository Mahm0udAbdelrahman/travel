<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use App\Http\Controllers\Controller;
use App\Services\Api\User\DeleteAccountService;

class DeleteAccountController extends Controller
{
    use   HttpResponse;
    public function __construct(public DeleteAccountService $deleteAccountService) {}

    public function deleteAccount()
    {
        return $this->deleteAccountService->deleteAccount();
    }
}
