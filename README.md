Users for MODX 3
---

> This extra is part of **MMX** initiative - the **M**odern **M**OD**X** approach.

### Dependencies

This package requires [mmxDatabase][mmx-database] to work with MODX database using Eloquent models.

The `mmx/database` dependency will be downloaded automatically by Composer.

### Prepare

This package can be installed only with Composer.

If you are still not using Composer with MODX 3, just download the `composer.json` of your version:
```bash
cd /to/modx/root/
wget https://raw.githubusercontent.com/modxcms/revolution/v3.0.5-pl/composer.json
```

### Install

```bash
composer require mmx/users --update-no-dev
composer exec mmx-users install
```

### Update

```bash
composer update mmx/users --no-dev
composer exec mmx-users install
```

### Remove

```bash
composer exec mmx-users remove
composer remove mmx/users
```

If you don't want to use mmxDatabase, you can also remove it.
```bash
composer exec mmx-database remove && composer remove mmx/database
```

### How to use

Just open **mmxUsers** extra section in MODX manager and enjoy!

[mmx-database]: https://packagist.org/packages/mmx/database

### System Settings

You can change the extra grids and forms look and feel with system settings.
Please read the description and look into default values.

**Grid** settings

Here you can specify the order and settings for columns.

Available columns are:
- **group-grid-columns**
    - regular UserGroup columns, like `id`, `name`, `description`, `rand`
    - nested options parent UserGroup with the same columns (`id`, `name`, etc...)
    - Special column with group users count: `members_count`
- **user-grid-columns**
    - regular User **and** Profile columns: `id`, `username`, `fullname`, `email`, etc...
    - values from extended fields: `extended.key1`, `extended.key2` and other. Can't be sortable.
    - values from UserSetting table: `setting.key1`, `setting.key2`. Can be sortable!

Supported settings:
- `type` - the type of column, supported are:
    - `boolean` to show yes\no icons
    - `text` or unset for other values
- `sortable` (true | false) to make column sortable.
- `sort` (true | false) specify this column as sorted by default
- `dir` specify the direction of column sorting (if `sort=true`)

**Tabs** settings

Those are very simple - you just specify wich tabs will be visible.

- **group-tabs-create**
- **group-tabs-edit**
- **user-tabs-create**
- **user-tabse-edit**

See settings description in MODX manager.

**Forms** settings

For now you can customize only users form.
I see no point to add this feature for user groups form, but feel free to write me about it.

**user-form-fields-available** - the list of all available fields of form with settings:
- `type`:
    - `text` - just regular text field
    - `email` - here and next the same text field but with specified `type="..."` attribute
    - `password`
    - `url`
    - `tel`
    - `textarea` - you should know what is it, right?
    - `checkbox` - regular checkbox for boolean values
    - `gender` - select with gender variants
    - `image` - this will open MODX browser to pick an uploaded image
    - `country` - select with countries list
    - `select` - select with custom options (don't forget to specify `options:["option1","option2"]` or `options:[{"value":1,"text":"Option 1"},{"value": 2,"text":"Option 2"}]`)
    - `user-password` - special component with changing user password along with confirmation
- `required` (true | false) should this field be required?
- `default` - the default value to set when you are creating the new user

**user-form-fields-user** and **user-form-fields-sudo**

2 system settings for managers with **sudo** permission and without.

Here you can specify the order of existing fields by beauty JSON arrays:
```json
[
    ["username", "fullname", ["active", "sudo"]],
    ["email", ["dob", "gender"]]
]
```

You will get 2 column form with nested fields, some of which are also split into 2 columns.
On mobile devices it will be 1 column form.