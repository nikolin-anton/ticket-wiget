<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Ticket;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected TicketRepository $ticketRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketRepo = new TicketRepository(new Ticket());
    }

    public function test_ticket_can_be_created(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->e164PhoneNumber(),
            'subject' => $this->faker->sentence(),
            'text' => $this->faker->text(),
        ];

        $ticket = $this->ticketRepo->create($data);

        $this->assertInstanceOf(Ticket::class, $ticket);
    }

    public function test_recent_ticket_found_by_phone_or_email(): void
    {
        Ticket::factory()->create([
            'customer_id' => Customer::factory()->create([
                'email' => 'test_email@mail.com',
                'phone' => '+380990000000',
            ]),
            'created_at' => now(),
        ]);

        $this->assertTrue($this->ticketRepo->findRecentByPhoneOrEmail('+380990000000', 'test_email@mail.com'));
    }

    public function test_update_ticket_status(): void
    {
        $user = Customer::factory()->create();

        $data = ['status' => 'processed'];

        $ticket = $this->ticketRepo->updateStatus(
            Ticket::factory()
            ->create(
                [
                    'customer_id' => $user->id,
                ]
            ),
            $data
        );
        $this->assertEquals('processed', $ticket->status);
        $this->assertEquals($user->id, $ticket->customer_id);
    }
}
