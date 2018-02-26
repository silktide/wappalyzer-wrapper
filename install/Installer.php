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
        $output = $event->getIo();
        $composer = $event->getComposer();
        $myDirectory = $composer->getInstallationManager()->getInstallPath(
            $composer->getRepositoryManager()->findPackage("silktide/wappalyzer-wrapper", "*")
        );

        chdir($myDirectory);
        exec('npm -v', $foo, $exitCode);
        $output->write("<info>npm version: {$foo[0]}</info>");

        if ($exitCode !== 0) {
            throw new \Exception("NPM not installed");
        }

        $output->write("<info>Installing Wappalyser</info>");
        exec('npm install', $stdOut, $exitCode);
        if ($exitCode !== 0) {
            throw new \Exception("NPM install failed");
        }
        $output->write("<info>NPM Version: ".$stdOut[0]."</info>");

        $version = json_decode(file_get_contents($myDirectory . "/node_modules/wappalyzer/package.json"), true);
        $output->write("<info>Wappalyzer Version: ".$version["_spec"]."</info>");
    }
}