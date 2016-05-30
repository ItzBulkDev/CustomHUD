<?php
namespace CustomHUD;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
  public function onEnable(){
    $this->saveDefaultConfig();
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $format = $config->get("Format");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(C::GREEN . "Enabled!");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new CustomHUD($this), $config->get("interval") * 20);
    $this->facs = FactionsPro::getInstance();
    $this->money = EconomyAPI::getInstance();
    if (!$this->facs) {
	  $this->getLogger()->info(TextFormat::RED."No factions plugin, {FAC_NAME} will not work");
	  $facs = "disabled";
	}
	if (!$this->economy) {
	  $this->getLogger()->info(TextFormat::RED."No Economy plugin, {money} will not work!");
	  $economy = "disabled";
	}
  }
  
  
  public function getMessage(Player $player){
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $message = $config->get("Message");
    
    //FACS AND ECONOMY
  if (!$this->facs) {
	  $fname = "None";
	}else{
	$fname = $this->facs->getPlayerFaction($player);
	}
	if (!$this->economy) {
	$money = "None";
	}else{
	$money = $economy->myMoney($player);
	}
	
	//
	
    $count = count($this->getServer()->getOnlinePlayers());
    $name = $player->getName();
    $m = str_replace("&","§",$message);
    $m = str_replace("{LINE}","\n",$message);
    $m = str_replace("{NAME}",$name,$message);
    $m = str_replace("{COUNT}",$count,$message);
    $m = str_replace("{FAC_NAME}"$fname,$message);
	return $m;
  }
  }

class CustomHUD extends PluginTask {
  
	public function __construct($plugin)
	{
		$this->plugin = $plugin;
		parent::__construct($plugin);
	}
	public function onRun($tick){
		$allplayers = $this->plugin->getServer()->getOnlinePlayers();
		foreach($allplayers as $p) {
			if($p instanceof Player) {	
			$message = $this->plugin->getMessage($p);
       $p->sendPopup($message);
			}
		}
	}
}
