<?php

declare(strict_types=1);

namespace duels\utils;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\plugin\PluginException;

class ItemUtils {

    /**
     * @param Item $item
     * @return string
     */
    public static function itemToString(Item $item): string {
        $data = $item->getId() . ':' . $item->getDamage() . ':' . $item->getCount();
        
        foreach ($item->getEnchantments() as $enchantment) {
            $data .= ':' . $enchantment->getId() . ';' . $enchantment->getLevel();
        }

        return $data;
    }

    /**
     * @param string $string
     * @return Item
     */
    public static function stringToItem(string $string): Item {
        if (strlen($string) < 2) {
            throw new PluginException('Invalid string');
        }

        $data = explode(':', $string);

        if (!isset($data[0], $data[1], $data[2])) {
            throw new PluginException('Invalid data');
        }

        $item = Item::get((int) $data[0], (int) $data[1], (int) $data[2]);

        for ($i = 3; $i < count($data); $i++) {
            if (!isset($data[$i])) continue;

            $enchantData = explode(';', $data[$i]);

            $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantData[0]), $enchantData[1]));
        }

        return $item;
    }
}