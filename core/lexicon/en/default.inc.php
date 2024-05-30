<?php

$_tmp = [
    'menu_name' => 'mmxUsers',
    'menu_desc' => 'Convenient management of MODX users',
    'actions' => [
        'create' => 'Create',
        'edit' => 'Edit',
        'submit' => 'Submit',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
    ],
    'models' => [
        'user' => [
            'title_one' => 'User',
            'title_many' => 'Users',
            'id' => 'Id',
            'username' => 'Username',
            'fullname' => 'Fullname',
            'email' => 'Email',
            'group' => 'Group',
            'active' => 'Active',
            'createdon' => 'Created On',
            'status' => [
                'any' => 'Any',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ]
        ],
        'user_group' => [
            'title_one' => 'User Group',
            'title_many' => 'User Groups',
            'id' => 'Id',
            'name' => 'Name',
            'description' => 'Description',
            'rank' => 'Rank',
            'parent' => 'Parent',
        ],
    ],
    'components' => [
        'no_data' => 'Nothing to display',
        'no_results' => 'Nothing found',
        'records' => 'No records | 1 record | {total} records',
        'query' => 'Search...',
        'delete' => [
            'title' => 'Confirmation required',
            'confirm' => 'Are you sure you want to delete this entry?',
        ],
    ],
    /* 'snippets' => [
        'nocss' => 'Do not load frontend styles',
    ], */
    'errors' => [
        'user' => [
            'username_unique' => 'User name must be unique.',
        ],
    ],
];

/** @var array $_lang */
$_lang = array_merge($_lang, MMX\Users\App::prepareLexicon($_tmp, MMX\Users\App::NAMESPACE));

$_tmp = [
    'some-setting' => 'Setting title',
    'some-setting_desc' => 'Some setting description',
];
$_lang = array_merge($_lang, MMX\Users\App::prepareLexicon($_tmp, 'setting_' . MMX\Users\App::NAMESPACE));

unset($_tmp);