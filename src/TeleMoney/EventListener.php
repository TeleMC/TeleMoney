<?php

namespace TeleMoney;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\Server;

class EventListener implements Listener {

    public function __construct(TeleMoney $plugin) {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $ev) {
        $server = Server::getInstance();
        $player = $ev->getPlayer();
        $name = strtolower($player->getName());
        if (!isset($this->plugin->data["Money"][$name])) {
            $this->plugin->data["Money"][$name] = $this->plugin->data["FirstJoin"];
        } else {
            return;
        }
    }

}
