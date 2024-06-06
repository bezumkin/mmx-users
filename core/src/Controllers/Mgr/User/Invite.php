<?php

namespace MMX\Users\Controllers\Mgr\User;

use Illuminate\Database\Capsule\Manager;
use MMX\Database\Models\User;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\Security\User\Create;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\Controller;

class Invite extends Controller
{
    protected modX $modx;

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    public function post(): ResponseInterface
    {
        /** @var User $user */
        if (!$user = User::query()->find($this->getProperty('user'))) {
            return $this->failure('Not Found', 404);
        }

        $processor = new Create($this->modx, ['notify_new_user' => true]);
        $topics = $processor->getLanguageTopics();
        foreach ($topics as $topic) {
            $this->modx->lexicon->load($topic);
        }
        $processor->profile = $user->Profile->getModxObject();
        $processor->object = $user->getModxObject();
        $processor->sendNotificationEmail();

        return $this->success();
    }
}