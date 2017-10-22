<?php

declare(strict_types=1);

namespace xenialdan\MagicWE2\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use xenialdan\MagicWE2\Loader;

class WandCommand extends PluginCommand{//TODO //togglewand
	public function __construct(Plugin $plugin){
		parent::__construct("/wand", $plugin);
		$this->setPermission("we.command.wand");
		$this->setDescription("Gives you the wand");
	}

	public function getUsage(): string{
		return parent::getUsage(); // TODO: Change the autogenerated stub
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$lang = Loader::getInstance()->getLanguage();
		/** @var Player $sender */
		$return = true;
		try{
			if ($sender instanceof Player){
				$lang = Loader::getInstance()->getLanguage();
				$item = ItemFactory::get(ItemIds::WOODEN_AXE);
				$item->addEnchantment(Enchantment::getEnchantment(Enchantment::PROTECTION));
				$item->setCustomName(Loader::$prefix . TextFormat::BOLD . TextFormat::DARK_PURPLE . 'Wand');
				$item->setLore([//TODO translation
					'Left click a block to set the position 1 of a selection',
					'Right click a block to set the position 2 of a selection',
					'Use //togglewand to toggle it\'s functionality'
				]);
				$item->setNamedTagEntry(new CompoundTag("MagicWE", []));
				$sender->getInventory()->addItem($item);
			} else{
				$sender->sendMessage(TextFormat::RED . "Console can not use this command.");
			}
		} catch (\TypeError $error){
			$sender->sendMessage(Loader::$prefix . TextFormat::RED . "Looks like you are missing an argument or used the command wrong!");
			$sender->sendMessage(Loader::$prefix . TextFormat::RED . $error->getMessage());
			$return = false;
		} finally{
			return $return;
		}
	}
}
