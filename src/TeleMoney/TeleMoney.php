<?PHP

namespace TeleMoney;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class TeleMoney extends PluginBase {

    private static $instance = null;
    public $pre = "§e•";

    //public $pre = "§l§e[ §f시스템 §e]§r§e";

    public static function getInstance() {
        return self::$instance;
    }

    public function onLoad() {
        self::$instance = $this;
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "Money.yml", Config::YAML, ["FirstJoin" => 1000]);
        $this->data = $this->config->getAll();
    }

    public function onDisable() {
        $this->save();
    }

    public function save() {
        $this->config->setAll($this->data);
        $this->config->save();
    }

    public function onCommand(CommandSender $sender, Command $command, $label, $args): bool {
        if ($command->getName() == "돈설정") {
            if (!isset($args[0]) || !is_numeric($args[0]) || $args[0] < 0)
                return false;
            $this->setMoney($sender->getName(), $args[0]);
        }
        return true;
    }

    public function setMoney($name, $amount) {
        if (!isset($this->data["Money"][strtolower($name)])) return;
        if ($amount < 0) return;
        $this->data["Money"][strtolower($name)] = $amount;
    }

    public function getMoney($name) {
        if (!isset($this->data["Money"][strtolower($name)])) return;
        return $this->data["Money"][strtolower($name)];
    }

    public function addMoney($name, $amount) {
        if (!isset($this->data["Money"][strtolower($name)])) return;
        if ($amount < 0) return;
        $this->data["Money"][strtolower($name)] += $amount;
    }

    public function reduceMoney($name, $amount) {
        if (!isset($this->data["Money"][strtolower($name)])) return;
        if ($amount < 0) return;
        $this->data["Money"][strtolower($name)] -= $amount;
    }
}
