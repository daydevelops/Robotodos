<?php

return [

    // Mail Notification
    'mail_notification' => env('MAIL_NOTIFICATION') ?: false,

    // Super Admin
    'super_admin' => env('APP_SUPER_ADMIN') ?: 1,

    // Default Avatar
    'default_avatar' => env('DEFAULT_AVATAR') ?: '/images/default.jpg',

    // Default Icon
    'default_icon' => env('DEFAULT_ICON') ?: '/images/favicon.ico',

    // Color Theme
    'color_theme' => 'daydev-theme',

    // Meta
    'meta' => [
        'keywords' => 'web development,blog,daydev,daydevelops,laravel,vuejs',
        'description' => 'Web Development Blog | Daydevelops'
    ],

    // Social Share
    'social_share' => [
        'article_share'    => env('ARTICLE_SHARE') ?: true,
        'discussion_share' => env('DISCUSSION_SHARE') ?: true,
        'sites'            => env('SOCIAL_SHARE_SITES') ?: 'twitter',
        'mobile_sites'     => env('SOCIAL_SHARE_MOBILE_SITES') ?: 'twitter',
    ],

    // Google Analytics
    'google' => [
        'id'   => env('GOOGLE_ANALYTICS_ID', 'Google-Analytics-ID'),
        'open' => false//env('GOOGLE_OPEN') ?: false
    ],

	'blog_information' => [
		'title' => 'Robotodos',
		'desc' => 'Hello friend, and welcome to Robotodos. My name is Adam and I spend a good portion of my time
		studying web development and tinkering with the odd robotics project. Eventually I realized that a lot of
		what I have learned along the way could help others on the same path.<br><br> So stick around for
		a while if you enjoy reading about technical tutorials, soft skills learning, and web development lessons
		I have learned the hard way, so you dont have to.<br><br> Please feel free to comment or contact me if you
		have something to say.'
	],

    // Article Page
    'article' => [
        'title'       => 'Robotodos',
        'description' => 'The collected ramblings of a web developer stumbling through the dark.',
        'number'      => 15,
        'sort'        => 'desc',
        'sortColumn'  => 'published_at',
    ],

    // Discussion Page
    'discussion' => [
		'title' => 'User Discussion Board',
		'subtitle' => 'Have an opinion, idea, or concern?',
        'number' => 10,
        'sort'   => 'desc',
        'sortColumn' => 'created_at',
    ],

    // Footer
    'footer' => [
        'github' => [
            'open' => true,
            'url'  => 'https://github.com/daydevelops/',
        ],
        'twitter' => [
            'open' => true,
            'url'  => 'https://twitter.com/daydevelops'
        ],
        'meta' => env('APP_NAME').', a derivitive of Jiajian Chan (<a href="https://github.com/jcc/blog">PJ Blog</a>)',
    ],

    'license' => 'Powered By Jiajian Chan.<br/>This article is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.',

];
