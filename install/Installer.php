<?php

namespace Silktide\WappalyzerInstall;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

class Installer implements PluginInterface, EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => ['install'],
            ScriptEvents::POST_UPDATE_CMD => ['install'],
        ];
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        // Move along, nothing to see here
    }

    public static function install(Event $event)
    {

        $composer = $event->getComposer();
        $myDirectory = $composer->getInstallationManager()->getInstallPath(
            $composer->getRepositoryManager()->findPackage("silktide/wappalyzer-wrapper", "*")
        );

        chdir($myDirectory);

        exec('npm -v', $foo, $exitCode);

        if ($exitCode !== 0) {
            throw new \exception("NPM not installed");
        }

        exec('npm install', $foo, $exitCode);

        if ($exitCode !== 0) {
            throw new \exception("NPM install failed");
        }
    }
}