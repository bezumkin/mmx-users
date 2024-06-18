<?php

namespace MMX\Users\Console\Command;

use MMX\Database\Models\Category;
use MMX\Database\Models\Menu;
use MMX\Database\Models\Namespaces;
use MMX\Database\Models\Plugin;
use MMX\Database\Models\SystemSetting;
use MMX\Users\App;
use MODX\Revolution\modX;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends Command
{
    protected static $defaultName = 'install';
    protected static $defaultDescription = 'Install mmxUsers for MODX 3';
    protected modX $modx;

    public function __construct(modX $modx, ?string $name = null)
    {
        parent::__construct($name);
        $this->modx = $modx;
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $srcPath = MODX_CORE_PATH . 'vendor/' . preg_replace('#-#', '/', App::NAMESPACE, 1);
        $corePath = MODX_CORE_PATH . 'components/' . App::NAMESPACE;
        $assetsPath = MODX_ASSETS_PATH . 'components/' . App::NAMESPACE;

        if (!is_dir($corePath)) {
            symlink($srcPath . '/core', $corePath);
            $output->writeln('<info>Created symlink for "core"</info>');
        }
        if (!is_dir($assetsPath)) {
            symlink($srcPath . '/assets/dist', $assetsPath);
            $output->writeln('<info>Created symlink for "assets"</info>');
        }

        if (!Namespaces::query()->find(App::NAMESPACE)) {
            $namespace = new Namespaces();
            $namespace->name = App::NAMESPACE;
            $namespace->path = '{core_path}components/' . App::NAMESPACE . '/';
            $namespace->assets_path = '{assets_path}components/' . App::NAMESPACE . '/';
            $namespace->save();
            $output->writeln('<info>Created namespace "' . $namespace->name . '"</info>');
        }

        if (!Menu::query()->where(['namespace' => App::NAMESPACE, 'action' => 'home'])->count()) {
            $menu = new Menu();
            $menu->namespace = App::NAMESPACE;
            $menu->action = 'home';
            $menu->parent = 'components';
            $menu->description = App::NAMESPACE . '.menu_desc';
            $menu->text = App::NAME;
            $menu->menuindex = Menu::query()->where('parent', 'components')->count();
            $menu->save();
            $output->writeln('<info>Created menu "' . $menu->text . '"</info>');
        }

        if (!$category = Category::query()->where('category', App::NAME)->first()) {
            $category = new Category();
            $category->category = App::NAME;
            $category->save();
            $output->writeln('<info>Created category "' . $category->category . '"</info>');
        }

        $settings = [
            'group-grid-columns' => [
                'xtype' => 'textarea',
                'value' => json_encode([
                    'id' => ['sortable' => true],
                    'name' => ['sortable' => true],
                    'parent.name' => ['sortable' => false],
                    'members_count' => ['sortable' => true],
                    'rank' => ['sortable' => true, 'sort' => true],
                ], JSON_THROW_ON_ERROR),
            ],
            'group-tabs-create' => [
                'xtype' => 'textfield',
                'value' => 'main',
            ],
            'group-tabs-edit' => [
                'xtype' => 'textfield',
                'value' => 'main,users',
            ],
            'user-grid-columns' => [
                'xtype' => 'textarea',
                'value' => json_encode([
                    'id' => ['sortable' => true, 'sort' => true, 'dir' => 'desc'],
                    'username' => ['sortable' => true],
                    'fullname' => ['sortable' => true],
                    'comment' => ['sortable' => true],
                    'email' => ['sortable' => true],
                    'settings.twofactoroptions' => ['sortable' => true, 'type' => 'boolean'],
                ], JSON_THROW_ON_ERROR),
            ],
            'user-form-fields-available' => [
                'xtype' => 'textarea',
                'value' => json_encode([
                    'username' => ['type' => 'text', 'required' => true],
                    'email' => ['type' => 'email', 'required' => true],
                    'fullname' => ['type' => 'text'],
                    'dob' => ['type' => 'date'],
                    'gender' => ['type' => 'gender'],
                    'website' => ['type' => 'url'],
                    'phone' => ['type' => 'tel'],
                    'mobilephone' => ['type' => 'tel'],
                    'fax' => ['type' => 'tel'],
                    'country' => ['type' => 'country'],
                    'state' => ['type' => 'text'],
                    'city' => ['type' => 'text'],
                    'zip' => ['type' => 'text'],
                    'address' => ['type' => 'textarea'],
                    'active' => ['type' => 'checkbox'],
                    'blocked' => ['type' => 'checkbox'],
                    'sudo' => ['type' => 'checkbox'],
                    'extended.pay_afterwards' => ['type' => 'checkbox', 'default' => false],
                    'settings.twofactoroptions' => ['type' => 'checkbox', 'default' => false],
                    'extended.main_branch' => ['type' => 'select', 'options' => ['', 'Drachten', 'Leeuwarden']],
                    'extended.max_days_order_overview' => ['type' => 'number', 'default' => 60],
                    'comment' => ['type' => 'text', 'required' => true],
                    'photo' => ['type' => 'image'],
                    'extended.company_logo' => ['type' => 'image'],
                    'password' => ['type' => 'user-password'],
                ], JSON_THROW_ON_ERROR),
            ],
            'user-form-fields-user' => [
                'xtype' => 'textarea',
                'value' => json_encode([
                    ['username', 'email', 'fullname', 'website', 'password'],
                    [['active', 'blocked'], ['extended.pay_afterwards', 'settings.twofactoroptions'], 'extended.main_branch', 'extended.max_days_order_overview', 'comment', 'extended.company_logo'],
                ], JSON_THROW_ON_ERROR),
            ],
            'user-form-fields-sudo' => [
                'xtype' => 'textarea',
                'value' => json_encode([
                    ['username', 'email', 'fullname', ['dob', 'gender'], 'website', ['phone', 'mobilephone'], 'fax', 'country', ['state', 'city', 'zip'], 'address'],
                    [['active', 'blocked', 'sudo'], ['extended.pay_afterwards', 'settings.twofactoroptions'], 'extended.main_branch', 'extended.max_days_order_overview', 'comment', 'photo', 'extended.company_logo', 'password'],
                ], JSON_THROW_ON_ERROR),
            ],
            'user-tabs-create' => [
                'xtype' => 'textfield',
                'value' => 'main,extended,groups',
            ],
            'user-tabs-edit' => [
                'xtype' => 'textfield',
                'value' => 'main,extended,groups,settings,commerce-addresses',
            ],
        ];
        foreach ($settings as $key => $data) {
            $key = implode('.', [App::NAMESPACE, $key]);
            if (!SystemSetting::query()->find($key)) {
                $setting = new SystemSetting();
                $setting->key = $key;
                $setting->namespace = App::NAMESPACE;
                $setting->fill($data);
                $setting->save();
                $output->writeln('<info>Created system setting "' . $setting->key . '"</info>');
            }
        }

        /** @var Plugin $plugin */
        if (!$plugin = Plugin::query()->where('name', App::NAME)->first()) {
            $plugin = new Plugin();
            $plugin->name = App::NAME;
            $plugin->category = $category->id;
            $plugin->plugincode = preg_replace('#^<\?php#', '', file_get_contents($corePath . '/elements/plugin.php'));
            $plugin->save();
            $output->writeln('<info>Created plugin "' . $plugin->name . '"</info>');
        }
        $pluginEvents = [
            'OnHandleRequest',
            'OnManagerPageInit',
        ];
        foreach ($pluginEvents as $name) {
            if (!$plugin->Events()->where('event', $name)->count()) {
                $plugin->Events()->create(['event' => $name]);
                $output->writeln('<info>Added event "' . $name . '" to plugin "' . $plugin->name . '"</info>');
            }
        }

//        $output->writeln('<info>Run Phinx migrations</info>');
//        $phinx = new TextWrapper(new PhinxApplication(), ['configuration' => $srcPath . '/core/phinx.php']);
//        if ($res = $phinx->getMigrate('local')) {
//            $output->writeln(explode(PHP_EOL, $res));
//        }

        $this->modx->getCacheManager()->refresh();
        $output->writeln('<info>Cleared MODX cache</info>');
    }
}
