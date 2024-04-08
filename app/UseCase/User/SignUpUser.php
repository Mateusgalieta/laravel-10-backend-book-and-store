<?php

namespace App\UseCase\User;

use App\Domain\User\SignUpUser as SignUpUserDomain;
use App\Models\User;
use App\Repositories\UserRepository;
use App\UseCase\BaseUseCase;
use App\UseCase\DTO\User\SignUpUserParams;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Throwable;

class SignUpUser extends BaseUseCase implements SignUpUserDomain
{
    /**
     * DTO to signup user
     */
    protected SignUpUserParams $params;

    public function __construct(
        SignUpUserParams $params,
    ) {
        $this->params = $params;
    }

    public function handle(): User
    {
        try {
            $this->params->password = Hash::make($this->params->password);

            return $this->instance(
                UserRepository::class,
            )->save($this->params->toArray());
        } catch (Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => $th->getMessage(),
                    'status' => false,
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }
}
