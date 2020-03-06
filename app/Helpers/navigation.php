<?php

use Illuminate\Http\Request;

function adminSideNavigation()
{
    $nav = '';
    $navigation = [];
    $activePage = \Request::segment(2);
    $activeSubPage = \Request::segment(3);
    $activePage = $activePage . "-" . $activeSubPage;

    $navigation[0] = [
        'name' => 'Site Members ',
        'activeValue' => 'sitemembers',
        'icon' => 'glyphicon glyphicon-user',
        'sub' => [
            [
                'name' => 'Member List',
                'activeValue' => 'site-member-list',
                'link' => route("admin-site-member-list"),
            ],
            [
                'name' => 'Author of Month List',
                'activeValue' => 'author-of-month-list',
                'link' => route("admin-month-author-list"),
            ],
            [
                'name' => 'Blocked IP Addresses',
                'activeValue' => 'blocked-ip-list',
                'link' => route("admin-blocked-ip-list"),
            ]
            /*[
                'name' => 'Author of Month',
                'link' => 'javascript:void(0)',
                'sub' => [
                    [
                        'name' => 'Author of Month List',
                        'activeValue' => 'author-of-month-list',
                        'link' => route("admin-month-author-list"),
                    ],
                    [
                        'name' => 'Add Author of Month',
                        'activeValue' => 'author-of-month-add',
                        'link' => route("admin-month-author-add"),
                    ]
                ]
            ]*/
        ],
    ];
    $navigation[1] = [
        'name' => 'Stories',
        'icon' => 'fa fa-commenting-o',
        'sub' => [
            [
                'name' => 'Manage Stories',
                'sub' => [
                    [
                        'name' => 'Stories List',
                        'activeValue' => 'stories-list',
                        'class' => 'clearStories',
                        'link' => route("admin-stories-list"),
                    ],
//                    [
//                        'name' => 'Stories List (NEW)',
//                        'activeValue' => 'stories-list1',
//                        'class' => 'clearStories',
//                        'link' => route("admin-stories-list1", ['_all']),
//                    ],
                    [
                        'name' => 'Add Story',
                        'activeValue' => 'stories-add',
                        'link' => route("admin-stories-add"),
                    ]
                ]
            ],
            [
                'name' => 'Manage Theme',
                'activeValue' => 'list',
                'sub' => [
                    [
                        'name' => 'Themes List',
                        'activeValue' => 'theme-list',
                        'link' => route("admin-theme-list"),
                    ],
                    [
                        'name' => 'Add Theme',
                        'activeValue' => 'theme-add',
                        'link' => route("admin-theme-add"),
                    ]
                ]
            ],
            [
                'name' => 'Manage Subjects',
                'sub' => [
                    [
                        'name' => 'Subjects List',
                        'activeValue' => 'subject-list',
                        'link' => route("admin-subject-list"),
                    ],
                    [
                        'name' => 'Add Subject',
                        'activeValue' => 'subject-add',
                        'link' => route("admin-subject-add"),
                    ]
                ]
            ],
            [
                'name' => 'Manage Categories',
                'activeValue' => 'list',
                'sub' => [
                    [
                        'name' => 'Categories List',
                        'activeValue' => 'category-list',
                        'link' => route("admin-category-list"),
                    ],
                    [
                        'name' => 'Add Category',
                        'activeValue' => 'category-add',
                        'link' => route("admin-category-add"),
                    ]
                ]
            ],
            [
                'name' => 'Manage Subcategories',
                'activeValue' => 'list',
                'sub' => [
                    [
                        'name' => 'Subcategories List',
                        'activeValue' => 'subcategory-list',
                        'link' => route("admin-subcategory-list"),
                    ],
                    [
                        'name' => 'Add Subcategory',
                        'activeValue' => 'subcategory-add',
                        'link' => route("admin-subcategory-add"),
                    ]
                ]
            ],
            [
                'name' => 'Manage Story Star',
                'activeValue' => 'story-star-list',
                'link' => route("admin-story-star-list"),
//                    'sub' => [
//                        [
//                            'name' => 'Story Star List',
//                            'activeValue' => 'story-star-list',
//                            'link' => route("admin-story-star-list"),
//                        ],
//                        [
//                            'name' => 'Add Story Star',
//                            'activeValue' => 'story-star-add',
//                            'link' => route("admin-story-star-add"),
//                        ]
//                    ]
            ]
        ],
    ];

    $navigation[] = [
        'name' => 'Manage Blogs',
        'icon' => 'fa fa-comment',
        'activeValue' => 'links-edit',
        'link' => route("admin-blog-list", ['id' => 1])
    ];

    $navigation[7] = [
        'name' => 'Top Star Portraits',
        'icon' => 'fa fa-star ',
        'sub' => [
            [
                'name' => 'Star Portraits List',
                'activeValue' => 'star-portraits-list',
                'link' => route("admin-star-list")
            ],
            [
                'name' => 'Add Star Portraits',
                'activeValue' => 'star-portraits-add',
                'link' => route("admin-star-add")
            ],
        ],
    ];

    $navigation[6] = [
        'icon' => 'fa fa-bookmark',
        'name' => 'Google Ads List',
        'activeValue' => 'ads-list',
        'link' => route("admin-ads-list")
    ];

    $navigation[8] = [
        'name' => 'Flagged Stories List',
        'icon' => 'fa fa-flag',
        'activeValue' => 'flag-list',
        'link' => route("admin-flag-list")
    ];

    $navigation[9] = [
        'name' => 'Manage Links',
        'icon' => 'fa fa-link',
        'activeValue' => 'links-edit',
        'link' => route("admin-links-edit", ['id' => 1])
    ];

    $navigation[10] = [
        'name' => 'Manage Contests',
        'icon' => 'fa fa-bank',
        'activeValue' => 'contest-edit',
        'link' => route("admin-contest-edit", ['id' => 2])
    ];
    $navigation[10] = [
        'name' => 'Manage Contests',
        'activeValue' => 'member',
        'icon' => 'fa fa-bank ',
        'link' => '#',
        'sub' => [
            ['name' => 'Content', 'activeValue' => 'contest-edit', 'link' => route("admin-contest-edit", ['id' => 2])],
            ['name' => 'Contest Entries', 'activeValue' => 'member-add', 'link' => route("admin-contest-entries")],
            ['name' => 'Brightest Stars Anthology', 'activeValue' => 'brightest-edit', 'link' => route("admin-contest-edit", ['id' => 3])],
            ['name' => 'Subscription service', 'activeValue' => 'subscription-edit', 'link' => route("admin-contest-edit", ['id' => 4])],
        ],
    ];

    $navigation[11] = [
        'icon' => 'fa fa-newspaper-o',
        'name' => 'Manage Subscribers',
        'activeValue' => 'subscriber-list',
        'link' => route("admin-subscriber-list"),

    ];

    $navigation[12] = [
        'name' => 'Back End Members',
        'activeValue' => 'member',
        'icon' => 'fa fa-key ',
        'link' => '#',
        'sub' => [
            ['name' => 'Manage Members', 'activeValue' => 'member-list', 'link' => route("admin-member-list")],
            ['name' => 'Add Manage Members', 'activeValue' => 'member-add', 'link' => route("admin-member-add")],
        ],
    ];

    $navigation[13] = [
        'name' => 'Points',
        'icon' => 'fa fa-money',
        'sub' => [
            [
                'name' => 'Manage Bad Words',
                'sub' => [
                    [
                        'name' => 'Bad Words List',
                        'activeValue' => 'points-bad-words-list',
                        'link' => route("admin-points-bad-words-list"),
                    ],
                    [
                        'name' => 'Add Bad Word',
                        'activeValue' => 'points-bad-words-add',
                        'link' => route("admin-points-bad-words-add"),
                    ]
                ]
            ],
            [
                'name' => 'History List',
                'activeValue' => 'points-history-list',
                'link' => route("admin-points-history-list"),
            ],
            [
                'name' => 'Add/Remove Points',
                'activeValue' => 'points-history-add',
                'link' => route("admin-points-history-add")
            ],
            [
                'name' => 'Manage On Hold',
                'activeValue' => 'points-on-hold-list',
                'link' => route("admin-points-on-hold-list")
            ],
            [
                'name' => 'Manage Categories',
                'activeValue' => 'points-category-list',
                'link' => route("admin-points-category-list")
            ]
        ],
    ];

    $navigation[14] = [
        'name' => 'Emails',
        'activeValue' => 'emails',
        'icon' => 'fa fa-envelope ',
        'link' => '#',
        'sub' => [
            ['name' => 'Add email template', 'activeValue' => 'create', 'link' => route("admin.email.create")],
            ['name' => 'Manage email templates', 'activeValue' => 'index', 'link' => route("admin.email.index")],
            ['name' => 'Send GROUP emails', 'activeValue' => 'template-add', 'link' => route("admin.email.send")],
            ['name' => 'Bounces and Complains', 'activeValue' => 'bounces', 'link' => route("admin.email.bounces")],

        ],
    ];

    ksort($navigation);

    foreach ($navigation as $mainNav) {
        $mainIcon = isset($mainNav['icon']) ? $mainNav['icon'] : '';
        $mainLink = isset($mainNav['link']) ? $mainNav['link'] : 'javascript:void(0)';
        $mainActiveValue = isset($mainNav['activeValue']) ? $mainNav['activeValue'] : '';
        $activeMainClass = ($activePage == $mainActiveValue) ? "active" : '';

        $subNavigation1 = '';

        if (isset($mainNav['sub']) && !empty(($mainNav['sub']))) {
            $subNavigation1 .= '<ul>';

            foreach ($mainNav['sub'] as $sl) {
                $subNavigation2 = "";

                if (isset($sl['sub']) && !empty($sl['sub'])) {
                    $subNavigation2 .= '<ul>';
                    foreach ($sl['sub'] as $s2) {
                        // Sub Nav Level 2
                        $activeSub2 = isset($s2['activeValue']) ? $s2['activeValue'] : '';
                        $linkSub2 = isset($s2['link']) ? $s2['link'] : 'javascript:void(0)';
                        $aClass = isset($s2['class']) ? $s2['class'] : '';
                        $activeClass2 = ($activePage == $activeSub2) ? "active" : '';
                        $name2 = isset($s2['name']) ? $s2['name'] : '';
                        $subNavigation2 .= <<<HTML
                                             <li class="{$activeClass2}">
                                                        <a href="{$linkSub2}" title="" class="$aClass">
                                                            <span  class="menu-item-parent">
                                                            {$name2}
                                                            </span>
                                                        </a>
                                             </li>
HTML;
                    }
                    $subNavigation2 .= '</ul>';
                }


                $linkSub1 = isset($sl['link']) ? $sl['link'] : 'javascript:void(0)';
                $nameSub1 = isset($sl['name']) ? $sl['name'] : '';
                $activeSub1 = isset($sl['activeValue']) ? $sl['activeValue'] : '';

                $activeSub1 = ($activePage == $activeSub1) ? "active" : '';
                // Sub Nav Level 1
                $subNavigation1 .= <<<HTML
                 <li class="{$activeSub1}">
                    <a href="{$linkSub1}" title="{$nameSub1}"><span  class="menu-item-parent">{$nameSub1}</span></a>
                    {$subNavigation2}
                 </li>
HTML;
            }
            $subNavigation1 .= '</ul>';
        }

        $nav .= <<<HTML
                  <li class="top-menu-invisible $activeMainClass">
                    <a href="$mainLink">
                        <i class="{$mainIcon}"></i>
                        <span class="menu-item-parent"> {$mainNav['name']}</span>
                    </a>
                    {$subNavigation1}
                </li>
              
HTML;

    }
    return $nav;

}

?>