<?php

/*
|--------------------------------------------------------------------------
| PROLIS Institute website content
|--------------------------------------------------------------------------
|
| Copy and structured content used across the website, based on the
| "PROLIS INSTITUTE website content" document. Slides, course areas, FAQs
| and contact details here are the starting content loaded by the
| ContentSeeder; after seeding they are managed from the admin dashboard.
|
*/

return [

    /*
    | The first admin account, created by the AdminUserSeeder. Set these in .env.
    */
    'admin' => [
        'name' => env('ADMIN_NAME', 'PROLIS Admin'),
        'email' => env('ADMIN_EMAIL', 'admin@prolisinstitute.com'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    'name' => 'PROLIS Institute',
    'full_name' => 'Professional Learning and Industry Skills Institute',
    'tagline' => 'Practical Skills. Professional Growth. Industry Readiness.',

    'contact' => [
        'email' => 'info@prolisinstitute.com',
        'phone' => '+233 531 037 131',
        'phone_link' => '+233531037131',
        'whatsapp' => '+233 531 037 131',
        'whatsapp_link' => '233531037131',
        'locations' => 'Accra and Sunyani, Ghana.',
        'hours' => 'Monday to Friday, 8:00 a.m. to 5:00 p.m.',
    ],

    'nav' => [
        'home' => 'Home',
        'about' => 'About Us',
        'courses' => 'Courses',
        'facilitators' => 'Facilitators',
        'admissions' => 'Admissions',
        'corporate' => 'Corporate Training',
        'news' => 'News',
        'contact' => 'Contact Us',
    ],

    'footer_links' => [
        'home' => 'Home',
        'about' => 'About Us',
        'courses' => 'Courses and Programmes',
        'facilitators' => 'Facilitators and Management',
        'admissions' => 'Admissions and Registration',
        'corporate' => 'Corporate Training',
        'portal' => 'Student Portal',
        'news' => 'News and Publications',
        'faq' => 'FAQs',
        'contact' => 'Contact Us',
    ],

    'slides' => [
        [
            'title' => 'Build Your Skills. Advance Your Career.',
            'image' => 'images/slider/slide-1.jpg',
            'image_alt' => 'Young professionals working together at a computer',
            'text' => "Our short professional courses give you practical skills, build your confidence at work, and get you ready for the way today's workplace is changing.",
            'buttons' => [['Explore Our Courses', 'courses'], ['Register Now', 'admissions']],
        ],
        [
            'title' => 'Learn Today. Lead Tomorrow.',
            'image' => 'images/slider/slide-2.jpg',
            'image_alt' => 'A facilitator presenting to a group of professionals',
            'text' => 'Learn communication, public relations, digital marketing, branding, event management, leadership, project management and more, all taught with real work in mind.',
            'buttons' => [['View Our Programmes', 'courses'], ['Get Started', 'admissions']],
        ],
        [
            'title' => 'Your Professional Growth Starts Here.',
            'image' => 'images/slider/slide-3.jpg',
            'image_alt' => 'A learner studying at a desk',
            'text' => 'Each course runs for one month, and you can choose to learn online or join us in person. Pick the option that fits your schedule and your goals.',
            'buttons' => [['Explore Courses', 'courses'], ['Contact Us', 'contact']],
        ],
    ],

    // Course areas: summary is used on the home page, items on the courses page.
    'course_areas' => [
        [
            'title' => 'Communication and Public Relations',
            'icon' => 'megaphone',
            'summary' => 'Strategic public relations, strategic communication, corporate communication, crisis communication and media relations.',
            'items' => ['Strategic Public Relations', 'Strategic Communication', 'Corporate Communication', 'Crisis Communication', 'Media Relations'],
        ],
        [
            'title' => 'Digital Marketing and Social Media',
            'icon' => 'device',
            'summary' => 'Digital marketing, social media management, digital communication, content strategy and influencer marketing.',
            'items' => ['Digital Marketing', 'Social Media Management', 'Digital Communication', 'Content Strategy', 'Strategic Influencer Marketing'],
        ],
        [
            'title' => 'Journalism, News Writing and Presentation',
            'icon' => 'news',
            'summary' => 'News writing and reporting, radio and TV presentation, digital journalism and mobile journalism.',
            'items' => [
                'News Writing and Reporting',
                'Radio and Television News Presentation',
                'Interviewing Techniques',
                'News Editing and Proofreading',
                'Investigative Journalism and Fact Checking',
                'Media Ethics and Professional Standards',
                'Feature Writing and Human Interest Stories',
                'Digital Journalism and Online News Production',
                'Mobile Journalism (MoJo)',
                'Public Speaking and Voice Training',
            ],
            'home' => false,
        ],
        [
            'title' => 'Branding and Marketing',
            'icon' => 'star',
            'summary' => 'Brand strategy, brand management, personal branding and marketing communication.',
            'items' => ['Brand Strategy', 'Brand Management', 'Personal Branding', 'Marketing Communication'],
        ],
        [
            'title' => 'Events and Event Marketing',
            'icon' => 'calendar',
            'summary' => 'Planning and running events, event marketing, conference management and exhibition management.',
            'items' => ['Event Planning and Management', 'Event Marketing', 'Conference Management', 'Exhibition Management'],
        ],
        [
            'title' => 'Leadership and Management',
            'icon' => 'users',
            'summary' => 'Leadership development, managing teams and growing as a professional.',
            'items' => ['Leadership Development', 'Team Management', 'Professional Development', 'Workplace Effectiveness'],
        ],
        [
            'title' => 'Project Management',
            'icon' => 'clipboard',
            'summary' => 'Planning and managing projects, keeping them coordinated, and monitoring and evaluating results.',
            'items' => ['Project Planning and Management', 'Project Coordination', 'Project Monitoring and Evaluation'],
        ],
        [
            'title' => 'Health Communication',
            'icon' => 'heart',
            'summary' => 'Health communication, public health campaigns, healthcare public relations and patient education.',
            'items' => ['Health Communication', 'Public Health Campaigns', 'Healthcare Public Relations', 'Patient Education'],
        ],
        [
            'title' => 'Public Speaking and Presentation',
            'icon' => 'mic',
            'summary' => 'Public speaking, giving professional presentations, speech writing and event moderation.',
            'items' => ['Public Speaking', 'Professional Presentation Skills', 'Speech Writing', 'Event Moderation'],
        ],
    ],

    'why_choose' => [
        ['Learning That Matches the Job', 'Our courses are built around what employers need and how industries are changing.', 'briefcase'],
        ['Learn Your Way', 'Study online or join us in person, whichever suits you better.', 'device'],
        ['Short and Focused', 'Each programme runs for one month, so you can build a skill properly without putting your life on hold.', 'clock'],
        ['Room to Grow', 'Whether you are a graduate, doing National Service, or already working, there is a course that takes you to the next step.', 'trending'],
        ['Training for Organisations', 'We also train teams, so organisations can invest in the people who keep them running.', 'building'],
    ],

    'audiences' => [
        'University graduates',
        'National Service Personnel',
        'Young professionals',
        'Working professionals',
        'Entrepreneurs',
        'Business owners',
        'Organisations',
    ],

    'objectives' => [
        'Offer short professional courses across a wide range of fields.',
        'Help people build the skills and confidence they need at work.',
        'Prepare graduates and National Service Personnel for their first professional roles.',
        'Encourage everyone to keep learning throughout their careers.',
        'Support organisations with training designed for their staff.',
        'Strengthen digital, communication, leadership and management skills.',
    ],

    'values' => [
        ['Excellence', 'We hold ourselves to high standards in everything we teach.'],
        ['Integrity', 'We are honest, open and accountable to our learners.'],
        ['Professionalism', 'We act responsibly and ethically, and we expect the same of our learners.'],
        ['Innovation', 'We keep up with new ideas, new tools and the way industries are changing.'],
        ['Relevance', 'We teach what people actually need in the workplace.'],
        ['Continuous Learning', 'We believe learning should never stop, at any stage of a career.'],
    ],

    'registration_steps' => [
        ['Explore Our Courses', 'Look through our programmes and find one that interests you.'],
        ['Choose Your Course', 'Pick your course and decide whether to learn online or in person, depending on availability.'],
        ['Fill In the Form', 'Complete the registration form with your details.'],
        ['Get Confirmation', 'Our team will contact you to confirm your place and explain what happens next.'],
        ['Start Learning', 'You will receive your course information and joining instructions.'],
    ],

    'corporate_areas' => [
        'Communication and Public Relations',
        'Digital Marketing and Social Media Management',
        'Branding and Marketing Communication',
        'Leadership and Management',
        'Project Management',
        'Public Speaking and Presentation Skills',
        'Event Planning and Management',
        'Health Communication',
        'Professional and Workplace Effectiveness',
    ],

    'news_categories' => [
        ['News and Announcements', 'New programmes, registration dates, Institute news and upcoming activities.', 'megaphone'],
        ['Professional Insights', 'Articles and ideas on communication, public relations, digital marketing, leadership, management and more.', 'news'],
        ['Career Development', 'Practical advice to help you grow in your career and stay ready for work.', 'trending'],
        ['Events and Activities', 'Workshops, seminars, training sessions and other events at the Institute.', 'calendar'],
    ],

    'faqs' => [
        ['What is PROLIS Institute?', 'PROLIS stands for Professional Learning and Industry Skills Institute. We run short professional courses and training for individuals and organisations.'],
        ['What courses do you offer?', 'We teach strategic public relations, strategic communication, digital marketing, social media management, branding, event management, project management, health communication, leadership and public speaking.'],
        ['How long do the courses last?', 'Our short courses run for one month.'],
        ['Are courses available online?', 'Yes. You can learn online or in person, depending on the programme and its schedule.'],
        ['Who can enrol?', 'Graduates, National Service Personnel, young professionals, working professionals, entrepreneurs and anyone else who wants to build their skills.'],
        ['How can I register?', 'Choose a course on our Courses and Programmes page and fill in the registration form, or contact us and we will help you.'],
        ['Where is PROLIS Institute located?', 'We serve learners in Accra and Sunyani, Ghana.'],
        ['Do you provide corporate training?', 'Yes. Organisations can contact us to talk about training for their staff.'],
        ['How can I contact PROLIS Institute?', 'Email info@prolisinstitute.com, or call or WhatsApp +233 531 037 131.'],
    ],

];
