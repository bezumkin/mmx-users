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
        'invite' => 'Invite',
        'more' => 'Show More',
    ],
    'models' => [
        'user' => [
            'title_one' => 'User',
            'title_many' => 'Users',
            'id' => 'Id',
            'username' => 'Username',
            'fullname' => 'Full Name',
            'email' => 'Email',
            'group' => 'Main Group',
            'active' => 'Active',
            'blocked' => 'Blocked',
            'sudo' => 'Sudo User',
            'photo' => 'Photo',
            'gender' => 'Gender',
            'gender_male' => 'Male',
            'gender_female' => 'Female',
            'gender_other' => 'Other',
            'dob' => 'Date of Birth',
            'comment' => 'Comment',
            'createdon' => 'Created On',
            'status' => [
                'any' => 'Any',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
            'password' => [
                'new' => 'New Password',
                'specified' => 'Enter Password',
                'confirm' => 'Confirm Password',
            ],
            'website' => 'Website',
            'phone' => 'Phone',
            'mobilephone' => 'Mobile phone',
            'fax' => 'Fax',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'zip' => 'Zip',
            'address' => 'Address',
            'tabs' => [
                'main' => [
                    'title' => 'Main',
                ],
                'extended' => [
                    'title' => 'Extended Fields'
                ],
                'settings' => [
                    'title' => 'Settings',
                    'disabled' => 'Save your user first. After that you are able to manage settings.',
                ],
                'groups' => [
                    'title' => 'User Groups'
                ],
                'commerce-addresses' => [
                    'title' => 'Commerce Addresses',
                    'disabled' => 'Save your user first. After that you are able to manage addresses.',
                    'info' => "Please add at least one billing address.<br><br>If you don't add a shipping address, the billing address will be used there as well."
                ],
            ],
            'filter' => [
                'any' => 'All Users',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
        'user_group' => [
            'title_one' => 'User Group',
            'title_many' => 'User Groups',
            'id' => 'Id',
            'name' => 'Name',
            'description' => 'Description',
            'rank' => 'Rank',
            'parent' => [
                'name' => 'Parent',
            ],
            'resource_group' => [
                'create' => 'Also Create Resource Group',
                'desc' => 'Specify Contexts that this User Group should be able to view.',
                'select' => 'Select Context...',
            ],
            'filter_any' => 'All Groups',
            'members_count' => 'Users',
            'tabs' => [
                'main' => [
                    'title' => 'Main',
                ],
                'users' => [
                    'title' => 'Users',
                    'disabled' => 'Save your group first. After that you are able to manage users.',
                ],
            ],
        ],
        'user_group_role' => [
            'title_one' => 'User Role',
            'title_many' => 'User Roles',
            'id' => 'Id',
            'name' => 'Name',
            'description' => 'Description',
            'authority' => 'Authority',
        ],
        'user_group_member' => [
            'title_one' => 'User Group Member',
            'title_many' => 'User Group Members',
            'id' => 'Member Id',
            'user_group' => 'User Group',
            'member' => 'User',
            'role' => 'User Role',
            'rank' => 'Rank',
        ],
        'user_setting' => [
            'title_one' => 'Setting',
            'title_many' => 'Settings',
            'key' => 'Key',
            'value' => 'Value',
            'xtype' => 'Type',
            'namespace' => 'Namespace',
            'area' => 'Area',
            'editedon' => 'Edited On',
            'types' => [
                'textfield' => 'Text Field',
                'textarea' => 'Text Area',
                'numberfield' => 'Number Field',
                'combo-boolean' => 'Boolean',
                'text-password' => 'Password Field',
                'modx-combo-category' => 'Categories',
                'modx-combo-charset' => 'Charsets',
                'modx-combo-country' => 'Countries',
                'modx-combo-context' => 'Contexts',
                'modx-combo-namespace' => 'Namespaces',
                'modx-combo-template' => 'Templates',
                'modx-combo-user' => 'Users',
                'modx-combo-usergroup' => 'User Groups',
                'modx-combo-language' => 'Languages',
                'modx-combo-source' => 'Sources',
                'modx-combo-source-type' => 'Source Types',
                'modx-combo-manager-theme' => 'Manager Themes',
                'modx-grid-json' => 'JSON Grid',
            ],
        ],
        'commerce' => [
            'address' => [
                'title_one' => 'Address',
                'title_many' => 'Addresses',
                'id' => 'Id',
                'type' => 'Type',
                'last_used' => 'Last Used',
                'company' => 'Company',
                // 'user' => 'User',
                'receiver' => 'Receiver',
                'fullname' => 'Fullname',
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'address' => 'Address',
                'address1' => 'Address 1',
                'address2' => 'Address 2',
                'address3' => 'Address 3',
                'zip' => 'Zip',
                'city' => 'City',
                'state' => 'State',
                'country' => 'Country',
                'phone' => 'Phone',
                'mobile' => 'Mobile',
                'notes' => 'Notes',
                'email' => 'Email',
                'types' => [
                    'any' => 'Filter by Type',
                    'shipping' => 'Shipping',
                    'billing' => 'Billing',
                ],
            ],
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
    'success' => [
        'user' => [
            'invited' => 'The invitation was successfully sent!',
        ]
    ],
    'errors' => [
        'user' => [
            'image_required' => 'Please select an image!',
        ],
    ],
];

/** @var array $_lang */
$_lang = array_merge($_lang, MMX\Users\App::prepareLexicon($_tmp, MMX\Users\App::NAMESPACE));

$_tmp = [
    'group-grid-columns' => 'User group grid columns',
    'group-grid-columns_desc' => 'Specify the order and settings of columns for user group grid',
    'group-tabs-create' => 'User group create tabs',
    'group-tabs-create_desc' => 'Tabs of user group modal when you create a new group. Available tabs are: main, users.',
    'group-tabs-edit' => 'User group edit tabs',
    'group-tabs-edit_desc' => 'Tabs of user group modal when you edit an existing group. Available tabs are: main, users.',
    'user-grid-columns' => 'User grid columns',
    'user-grid-columns_desc' => 'Specify the order and settings of columns for user grid',
    'user-form-fields-available' => 'Available user fields',
    'user-form-fields-available_desc' => 'The list of all user fields with settings',
    'user-form-fields-user' => 'User form fields',
    'user-form-fields-user_desc' => 'Fields of user form for regular manager.',
    'user-form-fields-sudo' => 'User fields for sudo',
    'user-form-fields-sudo_desc' => 'Fields of user form for manager with sudo permissions.',
    'user-tabs-create' => 'User create tabs',
    'user-tabs-create_desc' => 'Tabs of user modal when you create a new user. Available tabs are: main, extended, settings, groups and commerce-addresses.',
    'user-tabs-edit' => 'User edit tabs',
    'user-tabs-edit_desc' => 'Tabs of user modal when you edit an existing user. Available tabs are: main, extended, settings, groups and commerce-addresses.',
];
$_lang = array_merge($_lang, MMX\Users\App::prepareLexicon($_tmp, 'setting_' . MMX\Users\App::NAMESPACE));

unset($_tmp);