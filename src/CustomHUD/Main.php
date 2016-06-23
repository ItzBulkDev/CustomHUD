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
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new CustomHUD($this), 5);
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
                                if($this->message == 0){
                                	$message = $this->plugin->getConfig()->get("1");
                                	$m = str_replace("{LINE}","\n",$message);
                                	$m = str_replace("{NAME}",$name,$message);
					$p->sendTip($m);
                                }
				if($this->message == 1){
                                	$message = $this->plugin->getConfig()->get("2");
                                	$m = str_replace("{LINE}","\n",$message);
                                	$m = str_replace("{NAME}",$name,$message);
					$p->sendTip($m);
                                }
                                if($this->message == 2){
                                	$message = $this->plugin->getConfig()->get("3");
                                	$m = str_replace("{LINE}","\n",$message);
                                	$m = str_replace("{NAME}",$name,$message);
					$p->sendTip($m);
                                }
                                if($this->message == 3){
					$message = $this->plugin->getConfig()->get("4");
                                	$m = str_replace("{LINE}","\n",$message);
                                	$m = str_replace("{NAME}",$name,$message);
					$p->sendTip($m);
                                }
			}
			       if($this->message == 0){
					$this->message++;
                                }
				if($this->message == 1){
					$this->message++;
                                }
                                if($this->message == 2){
					$this->message++;
                                }
                                if($this->message == 3){
					$this->message--;
					$this->message--;
                                }
		}
        }
