<?php

namespace BasicCommands;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {

    public function onEnable(): void {
        $this->getLogger()->info("BasicCommands включен!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch ($command->getName()) {
            case "heal":
                if ($sender instanceof Player) {
                    $sender->setHealth($sender->getMaxHealth());
                    $sender->sendMessage(TextFormat::GREEN . "Ваше здоровье восстановлено!");
                } else {
                    $sender->sendMessage(TextFormat::RED . "Эта команда только для игроков!");
                }
                return true;

            case "feed":
                if ($sender instanceof Player) {
                    $sender->getHungerManager()->setFood(20);
                    $sender->getHungerManager()->setSaturation(20);
                    $sender->sendMessage(TextFormat::GREEN . "Ваша сытость восстановлена!");
                } else {
                    $sender->sendMessage(TextFormat::RED . "Эта команда только для игроков!");
                }
                return true;

            case "gm":
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $mode = (int)$args[0];
                        if ($mode >= 0 && $mode <= 3) {
                            $sender->setGamemode($mode);
                            $sender->sendMessage(TextFormat::GREEN . "Режим игры изменен на " . $mode);
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Неверный режим игры! Используйте 0, 1, 2 или 3.");
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Используйте: /gm <0|1|2|3>");
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Эта команда только для игроков!");
                }
                return true;

            case "fly":
                if ($sender instanceof Player) {
                    $sender->setAllowFlight(!$sender->getAllowFlight());
                    $sender->sendMessage(TextFormat::GREEN . "Режим полета " . ($sender->getAllowFlight() ? "включен" : "выключен"));
                } else {
                    $sender->sendMessage(TextFormat::RED . "Эта команда только для игроков!");
                }
                return true;

            case "tp":
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        $target = $this->getServer()->getPlayerExact($args[0]);
                        if ($target instanceof Player) {
                            $sender->teleport($target->getPosition());
                            $sender->sendMessage(TextFormat::GREEN . "Вы телепортированы к " . $target->getName());
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Игрок не найден!");
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Используйте: /tp <игрок>");
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Эта команда только для игроков!");
                }
                return true;

            default:
                return false;
        }
    }
}