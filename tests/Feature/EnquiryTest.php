<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_enquiry_is_stored(): void
    {
        $this->from('/contact-us')
            ->post('/enquiries', [
                'type' => 'contact',
                'name' => 'Ama Mensah',
                'email' => 'ama@example.com',
                'subject' => 'Course enquiry',
                'message' => 'When does the next digital marketing course start?',
            ])
            ->assertRedirect('/contact-us')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('enquiries', ['type' => 'contact', 'email' => 'ama@example.com']);
    }

    public function test_registration_requires_course_and_phone(): void
    {
        $this->from('/admissions-and-registration')
            ->post('/enquiries', [
                'type' => 'registration',
                'name' => 'Kofi Boateng',
                'email' => 'kofi@example.com',
            ])
            ->assertSessionHasErrors(['course', 'phone']);

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_registration_is_stored(): void
    {
        $attributes = Enquiry::factory()->registration()->raw();

        $this->post('/enquiries', $attributes)->assertSessionHas('status');

        $this->assertDatabaseHas('enquiries', [
            'type' => 'registration',
            'email' => $attributes['email'],
            'course' => $attributes['course'],
        ]);
    }

    public function test_corporate_request_requires_organisation(): void
    {
        $attributes = Enquiry::factory()->corporate()->raw(['organisation' => null]);

        $this->post('/enquiries', $attributes)->assertSessionHasErrors('organisation');
    }

    public function test_invalid_type_is_rejected(): void
    {
        $attributes = Enquiry::factory()->raw(['type' => 'spam']);

        $this->post('/enquiries', $attributes)->assertSessionHasErrors('type');
    }
}
