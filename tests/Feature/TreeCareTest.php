<?php

namespace Tests\Feature;

use App\Models\Seed;
use App\Models\Trees;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TreeCareTest extends TestCase
{
    use RefreshDatabase;

    // Crear un árbol para un usuario. $datos permite cambiar valores (nivel, progreso, etc.)
    private function crearArbol(User $user, array $datos = []): Trees
    {
        $seed = Seed::firstOrCreate(['name' => 'Roble'], ['price' => 10]);

        return Trees::create(array_merge([
            'user_id' => $user->id,
            'seed_id' => $seed->id,
            'level' => 0,
            'health' => 100,
            'progress' => 0,
            'status' => 'ACTIVE',
            'next_care_at' => null,
        ], $datos));
    }

        // 1. Cuidado exitoso: sube el progreso y se fija el próximo cuidado
    public function test_cuidado_exitoso(): void
    {
        $user = User::factory()->create();
        $tree = $this->crearArbol($user, ['health' => 50]);
        Sanctum::actingAs($user);

        $response = $this->postJson("/api/trees/{$tree->id}/care");

        $response->assertOk()
            ->assertJsonPath('message', 'Cuidado aplicado con éxito')
            ->assertJsonPath('tree.progress', 1)
            ->assertJsonPath('tree.health', 70);

        $tree->refresh();
        $this->assertEquals(1, $tree->progress);
        $this->assertNotNull($tree->next_care_at);
    }

        // 2. Cooldown: la segunda petición seguida da 409 y no cambia el progreso
    public function test_bloqueo_por_cooldown(): void
    {
        $user = User::factory()->create();
        $tree = $this->crearArbol($user);
        Sanctum::actingAs($user);

        $this->postJson("/api/trees/{$tree->id}/care")->assertOk();

        $response = $this->postJson("/api/trees/{$tree->id}/care");

        $response->assertStatus(409)
            ->assertJsonStructure(['error', 'next_care_at']);

        $this->assertEquals(1, $tree->fresh()->progress);
    }

        // 3. Ascenso de nivel: 5 cuidados válidos -> nivel 1 y progreso 0
    public function test_ascenso_de_nivel(): void
    {
        $user = User::factory()->create();
        $tree = $this->crearArbol($user);
        Sanctum::actingAs($user);

        for ($i = 0; $i < 5; $i++) {
            $this->postJson("/api/trees/{$tree->id}/care")->assertOk();
            $this->travel(61)->minutes();
        }

        $tree->refresh();
        $this->assertEquals(1, $tree->level);
        $this->assertEquals(0, $tree->progress);
    }

        // 4. MATURE: nivel 9 con progreso 4, un cuidado lo lleva a nivel 10 y MATURE
    public function test_evolucion_a_mature(): void
    {
        $user = User::factory()->create();
        $tree = $this->crearArbol($user, ['level' => 9, 'progress' => 4]);
        Sanctum::actingAs($user);

        $response = $this->postJson("/api/trees/{$tree->id}/care");

        $response->assertOk()
            ->assertJsonPath('tree.status', 'MATURE')
            ->assertJsonPath('tree.level', 10);

        $this->assertEquals('MATURE', $tree->fresh()->status);
    }

        // 5. Recurso cruzado: cuidar el árbol de otro usuario devuelve 403
    public function test_no_puede_cuidar_arbol_de_otro_usuario(): void
    {
        $dueno = User::factory()->create();
        $otro = User::factory()->create();
        $tree = $this->crearArbol($dueno);
        Sanctum::actingAs($otro);

        $response = $this->postJson("/api/trees/{$tree->id}/care");

        $response->assertForbidden();
        $this->assertEquals(0, $tree->fresh()->progress);
    }


}