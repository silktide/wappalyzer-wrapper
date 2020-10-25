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

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // Move along, nothing to see here
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // Move along, nothing to see here
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        // Move along, nothing to see here
    }

    public static function install(Event $event)
    {
        $output = $event->getIo();
        $composer = $event->getComposer();
        $wappalyzerWrapperDirectory = $composer->getInstallationManager()->getInstallPath(
            $composer->getRepositoryManager()->findPackage("silktide/wappalyzer-wrapper", "*")
        );

        $installDir = dirname(__DIR__, 1);
        $lockHashFile = $installDir .  "/npm-install.hash";

        if (file_exists($installDir . "/node_modules") && is_dir($installDir . "/node_modules")) {
            $output->write('Wappalyzer: Node modules already installed - checking installation');
        } else {
            if (file_exists($lockHashFile)) {
                unlink($lockHashFile);
            }
        }

        $packageLockFile = $installDir . "/package-lock.json";

        if (!file_exists($packageLockFile)) {
            $output->write("No package-lock.json. Assuming we're uninstalling");
            return;
        }

        $lockHash = hash_file('md5', $packageLockFile);

        if (!file_exists($lockHashFile) || file_get_contents($lockHashFile) !== $lockHash) {
            exec('npm -v', $npmVersion, $exitCode);
            $output->write("<info>npm version: {$npmVersion[0]}</info>");

            if ($exitCode !== 0) {
                throw new \Exception("<error>NPM not installed</error>");
            }

            $output->write("<info>Installing Wappalyzer</info>");
            exec("cd {$wappalyzerWrapperDirectory} && npm install", $stdOut, $exitCode);

            if ($exitCode !== 0) {
                throw new \Exception("<error>NPM install failed</error>");
            }

            file_put_contents($lockHashFile, $lockHash);
        } else {
            $output->write("Lockfile hash was correct, skipping npm install");
        }

        $packageJsonFilename = $wappalyzerWrapperDirectory . "/node_modules/wappalyzer/package.json";
        $version = json_decode(file_get_contents($packageJsonFilename), true);
        $output->write("<info>Wappalyzer Version: ".$version["_spec"]."</info>");
    }
}
