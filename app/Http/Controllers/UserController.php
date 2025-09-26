<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponseBuilder;
use App\Models\User;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class UserController extends Controller{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userServiceInterface){
        $this->userService = $userServiceInterface;
    }

    public function getAll(): JsonResponse{
        $responder = new ResponseBuilder();

        $users = $this->userService->all();

        if($users == null){
            return $responder->status(500, true, "failedToGatherUsers")->build();
        }

        return $responder->status(200, false, "usersGatheredSuccessfully")->data($users)->build();
    }

    public function getById(UserGetByIdData $userById): JsonResponse{
        $responder = new ResponseBuilder();

        $user = $this->userService->getById($userById->id);

        if($user == null){
            return $responder->status(500, true, "failedToGatherUser")->build();
        }

        return $responder->status(200, false, "userGatheredSuccessfully")->data($user)->build();
    }

    public function getStudents(): JsonResponse{
        $responder = new ResponseBuilder();

        $students = $this->userService->getStudents();
    }

    public function getProfessors(): JsonResponse{
        $responder = new ResponseBuilder();

        $professors = $this->userService->getProfessors();

        if($professors == null){
            return $responder->status(500, true, "failedToGatherProfessors")->build();
        }

        return $responder->status(200, false, 'gatheredProfessorsSuccessfully')->data($professors)->build();
    }

    public function getAdmins(): JsonResponse{
        $responder = new ResponseBuilder();

        $user = $this->userService->getAdmins();

        if($user === null){
            return $responder->status(500, true, "failedToGatherAdmins")->build();
        }

        return $responder->status(200, false, "usersGatheredSuccessfully")->data($user)->build();
    }

    public function update(UserUpdateData $userUpdate): JsonResponse{
        $responder = new ResponseBuilder();

        $updatedUser = $this->userService->update($userUpdate);

        if($updatedUser == null){
            return $responder->status(500, true, "failedToUpdateUser")->build();
        }

        return $responder->status(200, false, "userUpdatedSuccessfully")->data($updatedUser)->build();
    }

    public function delete(UserDeleteData $userDelete): JsonResponse{
        $responder = new ResponseBuilder();

        $isDeleted = $this->userService->delete($userDelete->id);

        if($isDeleted === null){
            return $responder->status(500, true, "failedToDeleteUser")->build();
        }

        return $responder->status(200, false, "userDeleted")->build();
    }
}
