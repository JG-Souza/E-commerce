<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;
use Exception;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(
 *     title="CRUD Ecommerce API",
 *     version="1.0",
 *     contact={
 *         "email"="joaogabriel.souza@codejr.com.br"
 *     }
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Access token obtido na autenticação",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerToken"
 * )
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="User ID"),
 *     @OA\Property(property="name", type="string", description="User's name"),
 *     @OA\Property(property="email", type="string", description="User's email"),
 *     @OA\Property(property="password", type="string", description="User's password"),
 *     @OA\Property(property="logradouro", type="string", description="User's address (street)"),
 *     @OA\Property(property="numero", type="string", description="User's address (number)"),
 *     @OA\Property(property="bairro", type="string", description="User's neighborhood"),
 *     @OA\Property(property="city", type="string", description="User's city"),
 *     @OA\Property(property="state", type="string", description="User's state"),
 *     @OA\Property(property="cep", type="string", description="User's postal code"),
 *     @OA\Property(property="country", type="string", description="User's country"),
 *     @OA\Property(property="phone", type="string", description="User's phone number"),
 *     @OA\Property(property="birth_date", type="string", format="date", description="User's birth date"),
 *     @OA\Property(property="cpf", type="string", description="User's CPF (Brazilian identification)"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the user was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the user was last updated")
 * )
 */

class UserController extends Controller
{
    const ITEMS_PER_PAGE = 6;

    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="Listar usuários",
     *     description="Retorna uma lista paginada de usuários.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número da página.",
     *         required=true,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/User")),
     *             @OA\Property(property="total_pages", type="integer"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na requisição",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
     *     )
     * )
     */
    public function index()
    {
        $page = $_GET['page'];
        $skip = ($page - 1) * UserController::ITEMS_PER_PAGE;
        $total_pages = ceil(User::count() / UserController::ITEMS_PER_PAGE);

        $users = User::get()->skip($skip)->take(UserController::ITEMS_PER_PAGE);

        return response()->json([
            'users' => $users,
            'total_pages' => $total_pages,
            'status' => 200
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="Detalhes do usuário",
     *     description="Retorna os detalhes de um usuário específico.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do usuário",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=202)
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'user' => $user,
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Usuário não encontrado",
                'status' => 202
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="Criar novo usuário",
     *     description="Cria um novo usuário na base de dados.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email", "password", "logradouro", "numero", "bairro", "city", "state", "cep", "country", "phone", "birth_date", "cpf"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="logradouro", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="birth_date", type="string"),
     *             @OA\Property(property="cpf", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=400),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=500)
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'logradouro' => 'required|string',
                'numero' => 'required|string',
                'bairro' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'cep' => 'required|string',
                'country' => 'required|string',
                'phone' => 'required|string',
                'birth_date' => 'required|string',
                'cpf' => 'required|string'
            ]);

            // Adicionando os campos que faltam manualmente
            $data['email_verified_at'] = now();
            $data['remember_token'] = Str::random(10);

            $new_user = User::create($data);

            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'user' => $new_user,
                'status' => 200
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
                'status' => 400
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro interno do servidor',
                'status' => 500
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="Atualizar usuário",
     *     description="Atualiza um usuário existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email", "password", "logradouro", "numero", "bairro", "city", "state", "cep", "country", "phone", "birth_date", "cpf"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="logradouro", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="birth_date", type="string"),
     *             @OA\Property(property="cpf", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update($request->all());

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'user' => $user,
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="Deletar usuário",
     *     description="Deleta um usuário existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deletado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message' => 'Usuário deletado com sucesso!',
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => 404
            ]);
        }
    }
}
