<?php

namespace MMX\Users;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use MODX\Revolution\modSystemEvent;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\ProcessorResponse;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Throwable;

class App
{
    public const NAME = 'mmxUsers';
    public const NAMESPACE = 'mmx-users';

    protected modX $modx;
    protected static ContainerInterface $container;

    public function __construct(modX $modx)
    {
        $this->modx = $modx;

        if (!$this->modx->services->has('mmxDatabase')) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Please install "mmx/database" package to use mmxUsers');
        }

        $container = new Container();
        $container->set(modX::class, $this->modx);
        $container->set('modx', $this->modx);
        static::$container = $container;
    }

    public static function getContainer(): ContainerInterface
    {
        return static::$container;
    }

    public function handleEvent(?modSystemEvent $event): void
    {
        if (!$event) {
            return;
        }

        if ($event->name === 'OnManagerPageInit' && $event->params['namespace'] === $this::NAMESPACE) {
            class_alias(Controllers\Modx\Home::class, '\MODX\Revolution\Controllers\Home');
        }
        if ($event->name === 'OnHandleRequest' && str_starts_with($_SERVER['REQUEST_URI'], '/' . $this::NAMESPACE)) {
            $this->run();
            exit();
        }
    }

    public function run(): void
    {
        $app = Bridge::create($this::getContainer());
        $app->addBodyParsingMiddleware();
        $app->addRoutingMiddleware();
        $app->setBasePath('/' . $this::NAMESPACE);
        $this::setRoutes($app);

        try {
            $_SERVER['QUERY_STRING'] = html_entity_decode($_SERVER['QUERY_STRING']);
            $app->run();
        } catch (Throwable $e) {
            $code = $e->getCode();
            http_response_code(is_numeric($code) ? $code : 500);
            echo json_encode($e->getMessage());
        }
    }

    protected static function setRoutes(\Slim\App $app): void
    {
        $app->group(
            '/mgr',
            static function (RouteCollectorProxy $group) {
                $group->any('/version', Controllers\Mgr\Version::class);
                $group->any('/countries', Controllers\Mgr\Countries::class);
                $group->any('/contexts', Controllers\Mgr\Contexts::class);
                $group->any('/namespaces', Controllers\Mgr\Namespaces::class);

                $group->any('/users[/{id:\d+}]', Controllers\Mgr\Users::class);
                $group->any('/user/{user:\d+}/groups[/{id:\d+}]', Controllers\Mgr\User\Groups::class);
                $group->any('/user/{user:\d+}/settings[/{key}]', Controllers\Mgr\User\Settings::class);
                $group->any('/user/{user:\d+}/invite', Controllers\Mgr\User\Invite::class);
                $group->any(
                    '/user/{user:\d+}/commerce/addresses[/{id:\d+}]',
                    Controllers\Mgr\User\CommerceAddresses::class
                );

                $group->any('/user-groups[/{id:\d+}]', Controllers\Mgr\UserGroups::class);
                $group->any('/user-group-roles[/{id:\d+}]', Controllers\Mgr\UserGroupRoles::class);
                $group->any('/user-group/{group:\d+}/users[/{id:\d+}]', Controllers\Mgr\UserGroup\Users::class);
            }
        )->add(Middlewares\Mgr::class);
    }

    public static function registerAssets($instance, bool $noCss = false): void
    {
        $context = $instance instanceof modX ? 'web' : 'mgr';
        $assets = self::getAssetsFromManifest($context);
        if ($assets) {
            // Production mode
            $jsMethod = $context === 'mgr' ? 'addHtml' : 'regClientHTMLBlock';
            $cssMethod = $context === 'mgr' ? 'addCss' : 'regClientCss';
            foreach ($assets as $file) {
                if (str_ends_with($file, '.js')) {
                    $instance->$jsMethod('<script type="module" src="' . $file . '"></script>');
                } elseif (!$noCss) {
                    $instance->$cssMethod($file);
                }
            }
        } else {
            // Development mode
            $port = getenv('NODE_DEV_PORT') ?: '9090';
            $connection = @fsockopen('node', $port);
            if (@is_resource($connection)) {
                $server = explode(':', MODX_HTTP_HOST);
                $baseUrl = MODX_ASSETS_URL . 'components/' . self::NAMESPACE . '/';
                $vite = MODX_URL_SCHEME . $server[0] . ':' . $port . $baseUrl;
                if ($instance instanceof modX) {
                    $instance->regClientHTMLBlock('<script type="module" src="' . $vite . '@vite/client"></script>');
                    $instance->regClientHTMLBlock('<script type="module" src="' . $vite . 'src/web.ts"></script>');
                } else {
                    $instance->addHtml('<script type="module" src="' . $vite . '@vite/client"></script>');
                    $instance->addHtml('<script type="module" src="' . $vite . 'src/mgr.ts"></script>');
                }
            }
        }
    }

    protected static function getAssetsFromManifest(string $context): ?array
    {
        $script = 'src/' . $context . '.ts';
        $baseUrl = MODX_ASSETS_URL . 'components/' . self::NAMESPACE . '/';
        $manifest = MODX_ASSETS_PATH . 'components/' . self::NAMESPACE . '/manifest.json';

        if (file_exists($manifest) && $files = json_decode(file_get_contents($manifest), true)) {
            $assets = [];
            if (!empty($files[$script])) {
                $file = $files[$script];
                $assets[] = $baseUrl . $file['file'];
                foreach ($file['css'] as $css) {
                    $assets[] = $baseUrl . $css;
                }

                return $assets;
            }
        }

        return null;
    }

    public static function prepareLexicon(array $arr, string $prefix = ''): array
    {
        $out = [];
        foreach ($arr as $k => $v) {
            $key = !$prefix ? $k : "{$prefix}.{$k}";
            if (is_array($v)) {
                $out += self::prepareLexicon($v, $key);
            } else {
                $out[$key] = $v;
            }
        }

        return $out;
    }

    public function getLexicon(string $locale = 'en', $prefixes = []): array
    {
        $namespace = $this::NAMESPACE;
        $this->modx->lexicon->load($locale . ':' . $namespace . ':default');
        $entries = [];

        if ($prefixes) {
            if (!is_array($prefixes)) {
                $prefixes = [$prefixes];
            }
            foreach ($prefixes as $prefix) {
                $entries += $this->modx->lexicon->fetch($namespace . '.' . $prefix);
            }
        } else {
            $entries = $this->modx->lexicon->fetch($namespace);
        }

        $keys = array_map(static function ($key) use ($namespace) {
            return str_replace($namespace . '.', '', $key);
        }, array_keys($entries));

        return array_combine($keys, array_values($entries));
    }

    public static function getErrorMessage(ProcessorResponse $response): string
    {
        if (!$message = $response->getMessage()) {
            $message = 'errors.unknown';
            if ($response->hasFieldErrors() && $errors = $response->getFieldErrors()) {
                $message = current($errors)->message;
            }
        }

        return $message;
    }
}