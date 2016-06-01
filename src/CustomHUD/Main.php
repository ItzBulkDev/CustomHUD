<?php
namespace CustomHUD;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
  public function onEnable(){
    $this->saveDefaultConfig();
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(C::GREEN . "Enabled!");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new CustomHUD($this), $config->get("interval"));
  }
}
  
  

class CustomHUD extends PluginTask{
	
	const MESSAGE = 0;
	
	
	public function __construct($plugin){
		$this->plugin = $plugin;
		parent::__construct($plugin);
		$this->message = CustomHUD::MESSAGE;
	}
	
	public function onRun($currentTick){
                        foreach($this->plugin->getServer()->getOnlinePlayers as $p){
                                if($this->countdownValue == 0){
					$p->sendMessage($this->plugin->getConfig->get("1"));
					$this->message++;
                                }
				if($this->countdownValue == 1){
					$p->sendMessage($this->plugin->getConfig->get("2"));
					$this->message++;
                                }
                                if($this->countdownValue == 2){
					$p->sendMessage($this->plugin->getConfig->get("3"));
					$this->message--;
					$this->message--;
                                }
			}
		}
        }
