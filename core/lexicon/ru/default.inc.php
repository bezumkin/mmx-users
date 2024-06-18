<?php

$_tmp = [
    'menu_name' => 'mmxUsers',
    'menu_desc' => 'Удобное управление пользователями MODX',
    'actions' => [
        'create' => 'Создать',
        'edit' => 'Изменить',
        'submit' => 'Отправить',
        'cancel' => 'Отмена',
        'delete' => 'Удалить',
        'invite' => 'Пригласить',
        'more' => 'Показать еще',
    ],
    'models' => [
        'user' => [
            'title_one' => 'Пользователь',
            'title_many' => 'Пользователи',
            'id' => 'Id',
            'username' => 'Имя пользователя',
            'fullname' => 'Полное имя',
            'email' => 'Электронная почта',
            'group' => 'Основная группа',
            'active' => 'Активный',
            'blocked' => 'Заблокирован',
            'sudo' => 'Неограниченные права',
            'photo' => 'Фотография',
            'gender' => 'Пол',
            'gender_male' => 'Мужчина',
            'gender_female' => 'Женщина',
            'gender_other' => 'Скрыт',
            'dob' => 'Дата рождения',
            'comment' => 'Комментарий',
            'createdon' => 'Дата создания',
            'status' => [
                'any' => 'Все',
                'active' => 'Активный',
                'inactive' => 'Заблокирован',
            ],
            'password' => [
                'new' => 'Новый пароль',
                'specified' => 'Введите пароль',
                'confirm' => 'Подтвердите пароль',
            ],
            'website' => 'Сайт',
            'phone' => 'Телефон',
            'mobilephone' => 'Мобильный',
            'fax' => 'Факс',
            'country' => 'Страна',
            'state' => 'Штат',
            'city' => 'Город',
            'zip' => 'Почтовый индекс',
            'address' => 'Адрес',
            'tabs' => [
                'main' => [
                    'title' => 'Основное',
                ],
                'extended' => [
                    'title' => 'Расширенные поля'
                ],
                'settings' => [
                    'title' => 'Настройки',
                    'disabled' => 'Сначала сохраните пользователя. После этого вы сможете управлять настройками.',
                ],
                'groups' => [
                    'title' => 'Группы пользователя'
                ],
                'commerce-addresses' => [
                    'title' => 'Адреса Commerce',
                    'disabled' => 'Сначала сохраните пользователя. После этого вы сможете управлять адресами.',
                    'info' => "Добавьте хотя бы один платежный адрес.<br><br>Если вы не добавите адрес доставки, будет использован платёжный адрес."
                ],
            ],
            'filter' => [
                'any' => 'Все юзеры',
                'active' => 'Активные',
                'inactive' => 'Отключенные',
            ],
        ],
        'user_group' => [
            'title_one' => 'Группа пользователей',
            'title_many' => 'Группы пользователей',
            'id' => 'Id',
            'name' => 'Название',
            'description' => 'Описание',
            'rank' => 'Сортировка',
            'parent' => [
                'name' => 'Родитель',
            ],
            'resource_group' => [
                'create' => 'Создать заодно и группу ресурсов',
                'desc' => 'Укажите контексты для новой группы ресурсов.',
                'select' => 'Выберите контекст...',
            ],
            'filter_any' => 'Все группы',
            'members_count' => 'Пользователи',
            'tabs' => [
                'main' => [
                    'title' => 'Основное',
                ],
                'users' => [
                    'title' => 'Пользователи',
                    'disabled' => 'Сначала сохраните свою группу. После этого вы сможете управлять пользователями.',
                ],
            ],
        ],
        'user_group_role' => [
            'title_one' => 'Роль пользователя',
            'title_many' => 'Роли пользователя',
            'id' => 'Id',
            'name' => 'Название',
            'description' => 'Описание',
            'authority' => 'Уровень доступа',
        ],
        'user_group_member' => [
            'title_one' => 'Участник группы пользователей',
            'title_many' => 'Участники группы пользователей',
            'id' => 'Id участника',
            'user_group' => 'Группа пользователей',
            'member' => 'Пользователь',
            'role' => 'Роль пользователя',
            'rank' => 'Сортировка',
        ],
        'user_setting' => [
            'title_one' => 'Настройка',
            'title_many' => 'Настройки',
            'key' => 'Ключ',
            'value' => 'Значение',
            'xtype' => 'Тип',
            'namespace' => 'Пространство имён',
            'area' => 'Раздел',
            'editedon' => 'Дата изменения',
            'types' => [
                'textfield' => 'Текстовое поле',
                'textarea' => 'Текстовая область',
                'numberfield' => 'Числовое поле',
                'combo-boolean' => 'Чекбокс',
                'text-password' => 'Пароль',
                'modx-combo-category' => 'Категории',
                'modx-combo-charset' => 'Кодировки',
                'modx-combo-country' => 'Страны',
                'modx-combo-context' => 'Контексты',
                'modx-combo-namespace' => 'Пространства имён',
                'modx-combo-template' => 'Шаблоны',
                'modx-combo-user' => 'Пользователи',
                'modx-combo-usergroup' => 'Группы пользователей',
                'modx-combo-language' => 'Языки',
                'modx-combo-source' => 'Источники файлов',
                'modx-combo-source-type' => 'Типы источников',
                'modx-combo-manager-theme' => 'Темы менеджера',
                'modx-grid-json' => 'JSON таблица',
            ],
        ],
        'commerce' => [
            'address' => [
                'title_one' => 'Адрес',
                'title_many' => 'Адресы',
                'id' => 'Id',
                'type' => 'Тип',
                'last_used' => 'Дата использования',
                'company' => 'Компания',
                // 'user' => 'User',
                'receiver' => 'Получатель',
                'fullname' => 'Полное имя',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'address' => 'Адрес',
                'address1' => 'Адрес 1',
                'address2' => 'Адрес 2',
                'address3' => 'Адрес 3',
                'zip' => 'Почтовый индекс',
                'city' => 'Город',
                'state' => 'Штат',
                'country' => 'Страна',
                'phone' => 'Телефон',
                'mobile' => 'Мобильный',
                'notes' => 'Заметки',
                'email' => 'Электронная почта',
                'types' => [
                    'any' => 'Тип адреса',
                    'shipping' => 'Адрес доставки',
                    'billing' => 'Адрес оплаты',
                ],
            ],
        ],
    ],
    'components' => [
        'no_data' => 'Нет данных для вывода',
        'no_results' => 'Результатов не найдено',
        'records' => 'Записей нет | {total} запись | {total} записи | {total} записей',
        'query' => 'Поиск...',
        'delete' => [
            'title' => 'Требуется подтверждение',
            'confirm' => 'Вы уверены, что хотите удалить эту запись?',
        ],
    ],
    'success' => [
        'user' => [
            'invited' => 'Приглашение было успешно отправлено!',
        ]
    ],
    'errors' => [
        'user' => [
            'image_required' => 'Пожалуйста, выберите изображение!',
        ],
    ],
];

/** @var array $_lang */
$_lang = array_merge($_lang, MMX\Users\App::prepareLexicon($_tmp, MMX\Users\App::NAMESPACE));

$_tmp = [
    'group-grid-columns' => 'Колонки таблицы групп пользователей',
    'group-grid-columns_desc' => 'Укажите порядок и настройки колонок таблицы с группами пользователей.',
    'group-tabs-create' => 'Вкладки создания группы пользователей',
    'group-tabs-create_desc' => 'Укажите активные вкладки при создании новой группы пользователей. На выбор доступны: main и users.',
    'group-tabs-edit' => 'Вкладки изменения группы пользователей',
    'group-tabs-edit_desc' => 'Укажите активные вкладки при изменении группы пользователей. На выбор доступны: main и users.',
    'user-grid-columns' => 'Колонки таблицы пользователей',
    'user-grid-columns_desc' => 'Укажите порядок и настройки колонок таблицы с пользователями.',
    'user-form-fields-available' => 'Все доступные поля пользователя',
    'user-form-fields-available_desc' => 'Список всех доступных полей пользователя вместе с настройками.',
    'user-form-fields-user' => 'Поля формы юзера для менеджера',
    'user-form-fields-user_desc' => 'Укажите доступные поля и порядок в форме редактирования пользователя для менедежера.',
    'user-form-fields-sudo' => 'Поля формы юзера для админа',
    'user-form-fields-sudo_desc' => 'Укажите доступные поля и порядок в форме редактирования пользователя для суперпозователя.',
    'user-tabs-create' => 'Вкладки создания пользователя',
    'user-tabs-create_desc' => 'Укажите активные вкладки при создании нового пользователя. На выбор доступны: main, extended, settings, groups и commerce-addresses.',
    'user-tabs-edit' => 'Вкладки изменения пользователя',
    'user-tabs-edit_desc' => 'Укажите активные вкладки при изменении пользователя. На выбор доступны: main, extended, settings, groups и commerce-addresses.',
];
$_lang = array_merge($_lang, MMX\Users\App::prepareLexicon($_tmp, 'setting_' . MMX\Users\App::NAMESPACE));

unset($_tmp);