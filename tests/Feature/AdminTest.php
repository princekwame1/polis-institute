<?php

namespace Tests\Feature;

use App\Models\CourseArea;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_sign_in(): void
    {
        $admin = $this->admin();

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'password'])
            ->assertRedirect('/admin');

        $this->assertAuthenticatedAs($admin);
    }

    public function test_sign_in_fails_with_wrong_password(): void
    {
        $admin = $this->admin();

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_users_are_turned_away(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertRedirect('/admin/login');

        $this->assertGuest();
    }

    /**
     * @return array<string, array{string}>
     */
    public static function adminPages(): array
    {
        return collect([
            '/admin', '/admin/enquiries', '/admin/slides', '/admin/slides/create',
            '/admin/course-areas', '/admin/course-areas/create', '/admin/faqs', '/admin/faqs/create',
            '/admin/posts', '/admin/posts/create', '/admin/facilitators', '/admin/facilitators/create',
            '/admin/settings', '/admin/account',
        ])->mapWithKeys(fn (string $uri): array => [$uri => [$uri]])->all();
    }

    #[DataProvider('adminPages')]
    public function test_admin_page_renders(string $uri): void
    {
        Enquiry::factory()->registration()->create();

        $this->actingAs($this->admin())->get($uri)->assertOk();
    }

    public function test_enquiries_can_be_filtered_and_marked_handled(): void
    {
        $registration = Enquiry::factory()->registration()->create(['name' => 'Kwame Asante']);
        Enquiry::factory()->create(['name' => 'Efua Mensah']);

        $this->actingAs($this->admin())
            ->get('/admin/enquiries?type=registration')
            ->assertSee('Kwame Asante')
            ->assertDontSee('Efua Mensah');

        $this->patch("/admin/enquiries/{$registration->id}", ['handled' => 1])->assertRedirect();

        $this->assertNotNull($registration->fresh()->handled_at);
    }

    public function test_slide_can_be_created_with_an_image(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post('/admin/slides', [
            'title' => 'Enrol for the January intake',
            'image' => UploadedFile::fake()->image('banner.jpg', 1920, 1080),
            'primary_button_text' => 'Register',
            'primary_button_url' => '/admissions-and-registration',
            'sort_order' => 1,
            'is_active' => 1,
        ])->assertRedirect('/admin/slides');

        $slide = Slide::sole();
        $this->assertSame('Enrol for the January intake', $slide->title);
        Storage::disk('public')->assertExists($slide->image);
    }

    public function test_slide_rejects_invalid_button_links(): void
    {
        $this->actingAs($this->admin())->post('/admin/slides', [
            'title' => 'Bad link',
            'primary_button_text' => 'Go',
            'primary_button_url' => 'javascript:alert(1)',
            'sort_order' => 1,
        ])->assertSessionHasErrors('primary_button_url');
    }

    public function test_course_area_courses_are_saved_one_per_line(): void
    {
        $this->actingAs($this->admin())->post('/admin/course-areas', [
            'title' => 'Data Skills',
            'icon' => 'clipboard',
            'items' => "Excel for Professionals\r\n\r\n  Data Visualisation  \nPower BI",
            'sort_order' => 1,
        ])->assertRedirect('/admin/course-areas');

        $area = CourseArea::sole();
        $this->assertSame(['Excel for Professionals', 'Data Visualisation', 'Power BI'], $area->items);
        $this->assertSame('data-skills', $area->slug);
        $this->assertFalse($area->show_on_home);
    }

    public function test_faq_can_be_updated_and_deleted(): void
    {
        $faq = Faq::factory()->create();
        $this->actingAs($this->admin());

        $this->put("/admin/faqs/{$faq->id}", ['question' => 'Updated?', 'answer' => 'Yes.', 'sort_order' => 2]);
        $this->assertSame('Updated?', $faq->fresh()->question);

        $this->delete("/admin/faqs/{$faq->id}");
        $this->assertModelMissing($faq);
    }

    public function test_draft_post_is_saved_without_publish_date(): void
    {
        $this->actingAs($this->admin())->post('/admin/posts', [
            'title' => 'Coming Soon: Leadership Masterclass',
            'category' => 'News and Announcements',
            'body' => 'Details to follow.',
            'status' => 'draft',
            'published_at' => now()->toDateTimeString(),
        ])->assertRedirect('/admin/posts');

        $post = Post::sole();
        $this->assertNull($post->published_at);
        $this->assertSame('coming-soon-leadership-masterclass', $post->slug);
    }

    public function test_posts_with_the_same_title_get_unique_slugs(): void
    {
        Post::factory()->create(['title' => 'Open Day', 'slug' => 'open-day']);

        $this->actingAs($this->admin())->post('/admin/posts', [
            'title' => 'Open Day',
            'category' => 'Events and Activities',
            'body' => 'Join us.',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('posts', ['slug' => 'open-day-2']);
    }

    public function test_settings_can_be_updated(): void
    {
        $this->actingAs($this->admin())->put('/admin/settings', [
            'email' => 'admissions@prolisinstitute.com',
            'phone' => '+233 200 000 000',
            'whatsapp' => '+233 200 000 000',
            'locations' => 'Accra, Ghana.',
            'hours' => 'Monday to Saturday',
            'facebook' => 'https://facebook.com/prolis',
        ])->assertRedirect();

        $this->assertSame('admissions@prolisinstitute.com', Setting::contact()['email']);
        $this->assertSame('233200000000', Setting::contact()['whatsapp_link']);
    }

    public function test_welcome_photo_can_be_replaced_from_settings(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->put('/admin/settings', [
            'email' => 'info@prolisinstitute.com',
            'phone' => '+233 531 037 131',
            'whatsapp' => '+233 531 037 131',
            'locations' => 'Accra and Sunyani, Ghana.',
            'hours' => 'Monday to Friday',
            'welcome_image' => UploadedFile::fake()->image('class.jpg', 1200, 1000),
            'welcome_image_alt' => 'Learners in a workshop',
        ])->assertSessionHasNoErrors();

        $path = Setting::get('welcome_image');
        Storage::disk('public')->assertExists($path);

        $this->get('/')
            ->assertSee('storage/'.$path)
            ->assertSee('Learners in a workshop');
    }

    public function test_password_change_requires_current_password(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put('/admin/account', [
            'name' => $admin->name,
            'email' => $admin->email,
            'current_password' => 'wrong',
            'password' => 'new-secret-123',
            'password_confirmation' => 'new-secret-123',
        ])->assertSessionHasErrors('current_password');

        $this->put('/admin/account', [
            'name' => $admin->name,
            'email' => $admin->email,
            'current_password' => 'password',
            'password' => 'new-secret-123',
            'password_confirmation' => 'new-secret-123',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('new-secret-123', $admin->fresh()->password));
    }

    public function test_admin_seeder_creates_admin_from_config_without_overwriting(): void
    {
        config(['prolis.admin' => ['name' => 'Site Admin', 'email' => 'owner@prolis.test', 'password' => 'first-password']]);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'owner@prolis.test')->sole();
        $this->assertTrue($admin->is_admin);
        $this->assertTrue(Hash::check('first-password', $admin->password));

        config(['prolis.admin.password' => 'second-password']);
        $this->seed(AdminUserSeeder::class);

        $this->assertTrue(Hash::check('first-password', $admin->fresh()->password));
    }
}
