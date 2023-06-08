<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    private $token;

    public function testRegister(): void
    {
        $userData = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 200,
                'message' => 'User created successfully',
            ]);
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    public function testLogin(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $credentials = [
            'email' => 'admin@gmail.com',
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/auth/login', $credentials);
        $this->token = $response->json('token');
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'token',
        ]);
    }

    public function testUserInfo(): void
    {
        $this->testLogin();
        $userFromDatabase = User::where('email', 'admin@gmail.com')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/user');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'result' => [
                    'id' => $userFromDatabase->id,
                    'name' => $userFromDatabase->name,
                    'email' => $userFromDatabase->email,
                ],
            ]);
    }

    public function testStore(): void
    {
        $userData = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '0912345678',
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Tạo mới thành công User',
            ]);

    }

    public function testIndex(): void
    {
        $users = User::factory()->count(3)->create();
        $response = $this->getJson('/api/users');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
    }
    public function testShow(): void
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }
    
    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $userData = [
            'name' => 'Updated Admin',
            'email' => 'updateadmin@gmail.com',
            'phone' => '0912345678',
            'password' => 'updatedpassword123',
        ];
        $response = $this->putJson('/api/users/' . $user->id, $userData);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Cập nhật thành công User',
            ]);
    }
    
    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Xóa thành công User',
            ]);
    }
}


