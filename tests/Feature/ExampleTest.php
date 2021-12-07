<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use WithFaker;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMappingStore()
    {

        $response = $this->post('/api/mapping/store',
            [
                'user_id' => 1,
                'note' => $this->faker->randomLetter,
                'plastic' => $this->faker->randomDigit,
                'iron' => $this->faker->randomDigit,
                'paper' => $this->faker->randomDigit,
                'id' => 20,
            ]
        );
        $response->assertStatus(200);
    }

    public function testMappingUpdate()
    {
        $response = $this->post('/api/mapping/update',
            [
                'id' => 12,
                'note' => $this->faker->randomLetter,
                'plastic' => $this->faker->randomDigit,
                'iron' => $this->faker->randomDigit,
                'paper' => $this->faker->randomDigit,
            ]
        );
        $response->assertStatus(200);
    }

    public function testMappingUpdateStatus()
    {
        $response = $this->post('/api/mapping/update',
            [
                'id' => 12,
                'status' => 1,
            ]
        );
        $response->assertStatus(200);
    }
}
