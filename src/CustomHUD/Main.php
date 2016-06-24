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
	
	public $this->joinTask;
	
  public function onEnable(){
    $this->saveDefaultConfig();
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(C::GREEN . "Enabled!");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new CustomHUD($this), $config->get("interval"));
    $this->getScheduler()->cancelTask($this->countdownTaskHandler->getTaskId());
  }
  
  public function onJoin(PlayerJoinEvent $event){
	$this->joinTask = $this->getServer()->getScheduler()->scheduleRepeatingTask(new JoinTask($this, $event->getPlayer()), 20);
  }
  
  public function stopTask(){
  $this->getScheduler()->cancelTask($this->joinTask->getTaskId());	
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

class JoinTask extends PluginTask{
	
	const TIME = 0;
	
	
	public function __construct($plugin, Player $p){
		$this->plugin = $plugin;
		$thus->player = $p;
		parent::__construct($plugin);
		$this->TIME = JoinTask::MESSAGE;
	}
	
	public function onRun($tick){
		if($this->TIME <= 2){
		$this->player->sendTip($this->plugin->getConfig()->get("join-message"));
		$this->TIME++;
        }
        	if($this->TIME >= 2){
        	$this->plugin->stopTask();
        	}
	}
	
        	}
