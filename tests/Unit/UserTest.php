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

    public function testSuccessRegister(): void
    {
        $userData = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password123',
            'phone' => '0912345678',
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
    public function testFailRegister(): void
    {
        $userData = [
            'name' => 'Admin',
            'email' => '',
            'password' => 'password123',
            'phone' => '0912345678',
        ];
        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                ($response->json('message'))? 'message' : 'errors' => $response->json('message') ??  $response->json('errors'),
            ]);
        
    }

    public function testSuccessLogin(): void
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
    public function testFailLogin(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $credentials = [
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/auth/login', $credentials);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }

    public function testSuccessUserInfo(): void
    {
        $this->testSuccessLogin();
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
    public function testFailUserInfo(): void
    {
        $this->token = '';
        $userFromDatabase = User::where('email', 'admin@gmail.com')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/user');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }

    public function testSuccessStore(): void
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
                'message' => $response->json('message'),
            ]);

    }
    public function testFailStore(): void
    {
        $userData = [
            'name' => '',//thiếu name
            'email' => 'admin@gmail.com',
            'phone' => '091234567f',//sai định dạng sđt
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => $response->json('errors'),
            ]);

    }

    public function testSuccessIndex(): void
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
            ])
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }
    public function testFailIndex(): void
    {
        $users = [];
        $response = $this->getJson('/api/users');
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }

    public function testSuccessShow(): void
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
            ])
            ->assertJson([
                'message' => $response->json('message'),
            ]);

    }
    public function testFailShow(): void
    {
        $userId = 9999; // User ID không tồn tại
        $response = $this->getJson('/api/users/' . $userId);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }
    
    public function testSuccessUpdate(): void
    {
        $user = User::factory()->create();
        $userData = [
            'name' => 'Updated Admin',
            'email' => 'updateadmin@example.com',
            'phone' => '0912345678',
            'password' => 'updatedpassword123',
        ];
        $response = $this->putJson('/api/users/' . $user->id, $userData);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }
    public function testFailUpdate(): void
    {
        $userId = 9999;// User ID không tồn tại
        $userData = [
            'name' => '',
            'email' => 'updateadmin@example.com',
            'phone' => '091234567d',
            'password' => 'updatedpassword123',
        ];
        $response = $this->putJson('/api/users/' . $userId, $userData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                ($response->json('message'))? 'message' : 'errors' => $response->json('message') ??  $response->json('errors'),
            ]);
    }
    
    public function testSuccessDestroy(): void
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }
    public function testFailDestroy(): void
    {
        $userId = 9999;// User ID không tồn tại
        $response = $this->deleteJson('/api/users/' . $userId);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'message' => $response->json('message'),
            ]);
    }
}


