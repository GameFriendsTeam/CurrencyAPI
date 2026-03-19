<?php
namespace gft\cur\command\sub;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\{RawStringArgument, FloatArgument};

use pocketmine\command\{Command, CommandSender};
use pocketmine\permission\DefaultPermissions;
use pocketmine\Server;

use gft\cur\player\Player;
use gft\cur\{API, Form, PluginEP};
use gft\cur\currency\Currency;

class SubAddCommand extends BaseSubCommand {
	public function __construct(
		private Currency $currency,
		private API $API
	) {
		parent::__construct("add", "add to balance currency");
		$this->setPermission(DefaultPermissions::ROOT_OPERATOR);
	}

	public function getAPI() : API{
		return $this->API;
	}

	protected function prepare(): void {
		$this->registerArgument(0, new FloatArgument("count", false));
		$this->registerArgument(1, new RawStringArgument("player", true));
	}
	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
		$target = $sender;
		if (isset($args["player"])) {
			$target = Server::getInstance()->getPlayerExact($args["player"]);
			if (is_null($target)) {
				$sender->sendMessage("§l§cPlayer not found online");
			}
		}

		if(!$sender instanceof \gft\cur\player\Player){
			//Assertion Fault
			return;
		}

		if(!$target instanceof \gft\cur\player\Player){
			//Assertion Fault
			return;
		}

		if (isset($args["count"])) {
			$count = $args["count"];
		} else {
			$this->sendUsage();
			return;
		}
		$target->add($this->currency->getName(), $count);
		$sender->sendMessage(
			str_replace(
				["{count}", "{sing}", "{balance}"],
				[$count, $this->currency->getSing(), (string) $sender->get($this->currency->getName())],
				API::getLang()->getNested("player.add")
			)
		);
	}
}
