<?php

namespace Tests\Feature;

use App\Models\Facilitator;
use App\Models\Post;
use App\Models\Setting;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed(ContentSeeder::class);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function pages(): array
    {
        return [
            'home' => ['/', 'Build Your Skills. Advance Your Career.'],
            'about' => ['/about-us', 'Our Core Values'],
            'courses' => ['/courses-and-programmes', 'Mobile Journalism (MoJo)'],
            'facilitators' => ['/facilitators-and-management', 'Meet the People Behind PROLIS Institute'],
            'admissions' => ['/admissions-and-registration', 'How to Register'],
            'corporate' => ['/corporate-training', 'Our Corporate Training Areas'],
            'portal' => ['/student-portal', 'Student Login'],
            'news' => ['/news-and-publications', 'Professional Insights'],
            'contact' => ['/contact-us', 'Send Us an Enquiry'],
            'faq' => ['/faqs', 'How long do the courses last?'],
            'privacy' => ['/policies/privacy-policy', 'Privacy Policy'],
            'terms' => ['/policies/terms-and-conditions', 'Terms and Conditions'],
            'refund' => ['/policies/registration-and-refund-policy', 'Registration and Refund Policy'],
        ];
    }

    #[DataProvider('pages')]
    public function test_page_renders_with_branding(string $uri, string $expectedText): void
    {
        $this->get($uri)
            ->assertOk()
            ->assertSee($expectedText)
            ->assertSee('images/logo.png')
            ->assertSee('images/preloader-logo.png')
            ->assertSee('favicon.ico');
    }

    public function test_unknown_policy_returns_not_found(): void
    {
        $this->get('/policies/unknown')->assertNotFound();
    }

    public function test_registration_form_preselects_course_from_query_string(): void
    {
        $this->get('/admissions-and-registration?course=Project+Management')
            ->assertOk()
            ->assertSee('<option value="Project Management" selected', false);
    }

    public function test_home_page_shows_slides_from_the_database(): void
    {
        $this->get('/')
            ->assertSee('Learn Today. Lead Tomorrow.')
            ->assertSee('storage/slides/slide-1.jpg');
    }

    public function test_published_post_is_listed_and_viewable(): void
    {
        $post = Post::factory()->create(['title' => 'New Digital Marketing Course']);

        $this->get('/news-and-publications')->assertSee('New Digital Marketing Course');
        $this->get('/news-and-publications/'.$post->slug)->assertOk()->assertSee($post->excerpt);
    }

    public function test_news_cards_show_category_date_and_reading_time(): void
    {
        Post::factory()->create([
            'title' => 'Featured Story',
            'category' => 'Career Development',
            'body' => str_repeat('word ', 450),
            'published_at' => now()->subDay(),
        ]);
        Post::factory()->create(['title' => 'Older Story', 'published_at' => now()->subWeek()]);

        $this->get('/news-and-publications')
            ->assertSeeInOrder(['Featured Story', 'Older Story'])
            ->assertSee('Career Development')
            ->assertSee('3 min read');
    }

    public function test_draft_post_is_hidden(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get('/news-and-publications')->assertDontSee($post->title);
        $this->get('/news-and-publications/'.$post->slug)->assertNotFound();
    }

    public function test_facilitator_profiles_replace_placeholders(): void
    {
        Facilitator::factory()->create(['name' => 'Akosua Owusu']);

        $this->get('/facilitators-and-management')
            ->assertSee('Akosua Owusu')
            ->assertDontSee('Profile coming soon');
    }

    public function test_updated_settings_appear_on_the_website(): void
    {
        Setting::store(['email' => 'hello@prolis.test']);

        $this->get('/contact-us')->assertSee('hello@prolis.test');
    }
}
