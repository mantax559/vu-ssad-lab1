<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mantax559\LaravelHelpers\Helpers\TableHelper;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ValidationHelper::getStringRules(),
            'email' => ValidationHelper::mergeRules(
                ValidationHelper::getEmailRules(),
                ValidationHelper::getUniqueRules(table: TableHelper::getName(model: User::class)),
            ),
            'password' => ValidationHelper::getPasswordRules(),
        ]);
    }

    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
