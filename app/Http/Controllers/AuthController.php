<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthService;
use App\Services\Auth\Exceptions\CompanyNotFoundException;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function login(Request $request, AuthService $authService): JsonResponse
    {
        try {
            $data = $this->getDataFromRequest($request);
            $authDTO = $authService->auth($data['login'], $data['password']);
            return new JsonResponse([
                'status' => 'success',
                "token" => $authService->getJwtToken($authDTO)
            ]);
        }
        catch (CompanyNotFoundException $e){
            return new JsonResponse([
                'status' => 'failure',
                'message' => "Unknown company"
            ]);
        }
        catch (Exception $e){
            return new JsonResponse([
                'status' => 'failure',
                'message' => $e->getMessage()
            ]);
        }

    }

    /**There are text/plain content type in sample requests which is not quite right. There must be application/json content type.
     * So we are manually validating data in this case
     * @param Request $request
     * @return void
     * @throws Exception
     */
    private function getDataFromRequest(Request $request): array
    {
        $data = [];
        if ($request->filled("login")){
            $data['login'] = $request->input("login");
        }
        if ($request->filled("password")){
            $data['password'] = $request->input("password");
        }
        if (empty($data) && !empty($request->getContent())){
           $data = json_decode($request->getContent(), true);
        }
        if (empty($data['login'])){
            throw new Exception("Login is empty");
        }
        if (empty($data['password'])){
            throw new Exception("Password is empty");
        }
        return $data;

    }
}
