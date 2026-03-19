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

class SubTransactionCommand extends BaseSubCommand {
	public function __construct(
		private Currency $currency,
		private API $API
	) {
		parent::__construct("transaction", "transaction between balances currency");
		$this->setPermission(DefaultPermissions::ROOT_USER);
	}

	public function getAPI() : API{
		return $this->API;
	}

	protected function prepare(): void {
		$this->registerArgument(0, new FloatArgument("count", false));
		$this->registerArgument(1, new RawStringArgument("player", false));
	}
	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
		$target = Server::getInstance()->getPlayerExact($args["player"]);
		if (!$target instanceof Player) return;
		if (isset($args["count"])) {
			$count = $args["count"];
		} else {
			$this->sendUsage();
			return;
		}

		if(!$sender instanceof \gft\cur\player\Player){
			//Assertion Fault
			return;
		}

		$sender->transaction($this->currency->getName(), $count, $target);
	}
	
	public function getPermission(): ?string {
		return DefaultPermissions::ROOT_USER;
	}
}
