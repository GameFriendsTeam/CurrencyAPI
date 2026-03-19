<?php
namespace gft\cur\event;

use pocketmine\event\Event;
use pocketmine\event\Cancellable;
use gft\cur\player\Player;
use gft\cur\currency\Currency;
use pocketmine\event\CancellableTrait;

class RemoveEvent extends Event implements Cancellable {
	use CancellableTrait;

    public function __construct(
		private Player $player,
		private float $count,
		private Currency $currency
	) {}

	public function getPlayer() : Player { return $this->player; }
	public function getCount() : float { return $this->count; }
	public function getCurrency() : Currency { return $this->currency; }
}