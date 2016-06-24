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
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener{
	
	public $joinTask;
	
  public function onEnable(){
    $this->saveDefaultConfig();
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(C::GREEN . "Enabled!");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new CustomHUD($this), $config->get("interval"));
  }
  
  public function onJoin(PlayerJoinEvent $event){
	                        	$name = $event->getPlayer()->getName();
                                	$message = $this->getConfig()->get("join-message");
                                	$m = str_replace("{LINE}","\n",$message);
                                	$m = str_replace("{NAME}",$name,$message);
					$event->getPlayer()->sendTip($m);
  }
  
}
  
  

class CustomHUD extends PluginTask{
	
	const MESSAGE = 0;
	
	
	public function __construct($plugin){
		$this->plugin = $plugin;
		parent::__construct($plugin);
		$this->message = CustomHUD::MESSAGE;
	}
	
	public function onRun($tick){
                        foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
                        	$name = $p->getName();
                                	$message = $this->plugin->getConfig()->get($this->message);
                                	$m = str_replace("{LINE}","\n",$message);
                                	$m = str_replace("{NAME}",$name,$message);
					$p->sendTip($m);
			}
                                if($this->message < 4){
					$this->message++;
                                }
                                if($this->message == 4){
					$this->message--;
					$this->message--;
					$this->message--;
                                }
		}
        }
