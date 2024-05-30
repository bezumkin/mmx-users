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