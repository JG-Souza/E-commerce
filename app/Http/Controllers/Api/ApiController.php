<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

/**
 * @OA\Info(title="API Documentation", version="1.0")
 */
class ApiController extends Controller
{
    const ITEMS_PER_PAGE = 6;

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar usuários",
     *     description="Retorna uma lista de usuários com nome e imagem de perfil.",
     *     operationId="showUsers",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número da página de resultados.",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários com a imagem de perfil.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="total_pages", type="integer", example=4),
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="img_path", type="string", example="/files/default-photo.png")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parâmetro de página ausente ou inválido.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="Parâmetro de página inválido.")
     *         )
     *     )
     * )
     */
    public function showUsers()
    {
        $page = $_GET['page'];
        $skip = ($page - 1) * ApiController::ITEMS_PER_PAGE;
        $total_pages = ceil(User::count() / ApiController::ITEMS_PER_PAGE);

        $users = User::skip($skip)->take(ApiController::ITEMS_PER_PAGE)
        ->get(['name', 'img_path'])
        ->map(function ($user) {
            return [
                'name' => $user->name,
                'img_path' =>$user->img_path ? '/files/' . $user->img_path : '/files/default-photo.png',
            ];
        });

        return response()->json([
                'users' => $users,
                'total_pages' => $total_pages,
                'status' => 200
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/admins",
     *     summary="Listar administradores",
     *     description="Retorna uma lista de administradores com nome e imagem de perfil.",
     *     operationId="showAdmins",
     *     tags={"Admins"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número da página de resultados.",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de administradores com a imagem de perfil.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="total_pages", type="integer", example=4),
     *             @OA\Property(
     *                 property="admins",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="Admin Name"),
     *                     @OA\Property(property="img_path", type="string", example="/files/default-photo.png")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parâmetro de página ausente ou inválido.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="Parâmetro de página inválido.")
     *         )
     *     )
     * )
     */
    public function showAdmins()
    {
        $page = $_GET['page'];
        $skip = ($page - 1) * ApiController::ITEMS_PER_PAGE;
        $total_pages = ceil(User::count() / ApiController::ITEMS_PER_PAGE);

        $admins = Admin::skip($skip)->take(ApiController::ITEMS_PER_PAGE)->get(['name', 'img_path'])
        ->map(function ($admin) {
            return [
                'name' => $admin->name,
                'img_path' =>$admin->img_path ? '/files/' . $admin->img_path : '/files/default-photo.png',
            ];
        });

        return response()->json([
                'admins' => $admins,
                'total_pages' => $total_pages,
                'status' => 200
        ]);
    }
}
