<?php

namespace MMX\Users\Controllers\Modx;

use MMX\Users\App;
use MODX\Revolution\modExtraManagerController;

class Home extends modExtraManagerController
{
    public function loadCustomCssJs(): void
    {
        App::registerAssets($this);
        $this->addHtml('<script>MODx.user.sudo = ' . $this->modx->user->sudo . '</script>');
    }

    public function getPageTitle(): string
    {
        return App::NAME;
    }

    public function getLanguageTopics(): array
    {
        return [App::NAMESPACE . ':default'];
    }

    public function getTemplateFile(): string
    {
        /** @var App $app */
        $app = $this->modx->services->get(App::NAME);
        $locale = $this->modx->getOption('manager_language', $_SESSION, $this->modx->getOption('cultureKey')) ?: 'en';
        $data = [
            'locale' => $locale,
            'lexicon' => $app->getLexicon($locale),
        ];
        $this->content .= '<div id="' . App::NAMESPACE . '-root" class="mmx-users"></div>';
        $this->content .= '<script>' . App::NAME . '=' . json_encode($data) . '</script>';

        return '';
    }
}