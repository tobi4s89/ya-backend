<?php

namespace App;

use App\Transformers\PropertyTransformer;

class Comparison extends Algorithm
{
    /**
     * Maximale en volledige waarde (%)
     *
     */
    const FULLVALUE = 100;


    /**
     * Haal naam op eerste user
     *
     * @return String
     */
    public function getNameFirstUser()
    {
        $user = User::findOrFail($this->firstUser);

        return $user->name;
    }


    /**
     * Haal naam op tweede user
     *
     * @return String
     */
    public function getNameSecondUser()
    {
        $user = User::findOrFail($this->secondUser);

        return $user->name;
    }


    /**
     * Haal de items op van eerste user
     *
     * @return array $items
     */
    public function getItemsFirstUser()
    {
        $user = User::findOrFail($this->firstUser);
        $items = fractal($user->properties, new PropertyTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())->toArray();
        $sortedItems = $this->sortItemsByPosition($items);

        return $sortedItems;
    }


    /**
     * Haal de items op van tweede user
     *
     * @return array $items
     */
    public function getItemsSecondUser()
    {
        $user = User::findOrFail($this->secondUser);
        $items = fractal($user->properties, new PropertyTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())->toArray();
        $sortedItems = $this->sortItemsByPosition($items);

        return $sortedItems;
    }


    /**
     * Sorteer items op positie
     * @param array $items
     *
     * @return array $sortedItems
     */
    public function sortItemsByPosition(array $items)
    {
        $sortedItems = [];

        foreach($items as $item) {
            $position = $item['position'];

            $sortedItems[$position] = $item;
        }

        ksort($sortedItems);

        return $sortedItems;
    }


    /**
     * Aantal gevraagde items van eerste user
     *
     * @return Integer
     */
    public function getPropQty()
    {
        $value = count($this->getItemsFirstUser());

        return $value;
    }


    /**
     * Haal alle overeenkomende items op van beide users
     *
     */
    public function getMatchingItems()
    {
        $items = [];
        $itemsFirstUser = $this->getItemsFirstUser();
        $itemsSecondUser = $this->getItemsSecondUser();

        foreach ($itemsFirstUser as $itemX) {
            // Search for key id value, and keep the correct keys
            $key = array_search($itemX['id'], array_combine(array_keys($itemsSecondUser), array_column($itemsSecondUser, 'id')));

            if ($key) {
                $items[$itemX['position']] = $itemX;
                $items[$itemX['position']]['positionY'] = $itemsSecondUser[$key]['position'];
            }
        }

        if(!empty($items)) {
            return $items;
        }

        return false;
    }


    /**
     * Haal alle verplichte overeenkomende items van eerste user op
     *
     * @return array $items
     */
    public function getRequiredItems()
    {
        $items = [];

        foreach($this->getItemsFirstUser() as $item) {
            if($item['required'] === 1) {
                $items[] = $item;
            }
        }

        return $items;
    }


    /**
     * Aantal VERPLICHTE overeenkomende items van eerste user
     *
     * @return Integer
     */
    public function getRequiredPropQty()
    {
        $value = count($this->getRequiredItems());

        return $value;
    }


    /**
     * Aantal overeenkomende items van beide users
     *
     * @return int $value
     */
    public function getMatchedPropQty()
    {
        $value = count($this->getMatchingItems());

        return $value;
    }


    /**
     * Check of alle VERPLICHTE overeenkomende items van de eerste
     * partij voorkomen in alle overeenkomende items
     *
     * @return Boolean
     */
    public function hasMatchedRequirements()
    {
        $requiredMatchItems = [];

        if($this->getRequiredPropQty() > 0 && $this->getMatchingItems()) {

            $requiredMatchItems = array_uintersect($this->getRequiredItems(), $this->getMatchingItems(), function($val1, $val2) {
                return strcmp($val1['id'], $val2['id']);
            });
        }

        if($this->getRequiredPropQty() === count($requiredMatchItems) || $this->getRequiredPropQty() === 0) {
            return true;
        }

        return false;
    }


    /**
     * Haal correctiewaarde op t.o.v. algoritme
     *
     * @param string $totalPropValue
     *  Waarde wordt berekend in getScore()
     *
     * @return string
     */
    public function getCorrectionValue($totalPropValue)
    {
        $value = 0;

        if($this->getPropQty() > 0) {
            $calcValue = (self::FULLVALUE / $this->getPropQty()) * $this->getMatchedPropQty();

            $value = $calcValue - $totalPropValue;
        }

        return $value;
    }


    /**
     * Haal de boostwaarde op
     *
     * @param string $remainValue
     * @param int $requiredQty
     * Waarde is op te halen met getRequiredPropQty
     *
     * @return int $value
     */
    public function getTotalRequiredValue($remainValue, $requiredQty)
    {
        $value = 0;

        if($this->getMatchedPropQty() > 0) {
            $value = ($remainValue / $this->getMatchedPropQty()) * $requiredQty;
        }

        return $value;
    }


    /**
     * Haal totaal waarde op t.o.v. algoritme
     *
     * @param int $correctionValue
     * @param int $totalMustValue
     *
     * @return Integer
     */
    public function getTotalValue($correctionValue, $totalMustValue)
    {
        $value = round($correctionValue + $totalMustValue);

        return $value;
    }


    /**
     * Bereken de totaalwaarde t.o.v. algoritme
     *
     * Als VERPLICHTE overeenkomende items van eerste partij
     * overeenkomen met de tweede partij
     * @return String
     *
     * Als VERPLICHTE overeenkomende items van eerste partij
     * niet overeenkomen met de tweede partij
     *
     * @return Boolean
     */
    public function getScore()
    {

        if($this->hasMatchedRequirements()) {
            $propQty = $this->getPropQty();
            $propQtyMust = $this->getRequiredPropQty();
            $totalPropValue = 0;

            foreach($this->getMatchingItems() as $prop) {
                $posX = $prop['position'];
                $posY = $prop['positionY'];

                $posValueFactor = (($propQty + 1) - $posX) / $propQty;
                $diffFactor = abs($posX - $posY);
                $propPosValue = $posValueFactor * $diffFactor;
                $totalPropValue += $propPosValue;
            }

            $correctionValue = $this->getCorrectionValue($totalPropValue);
            $remainValue = self::FULLVALUE - $correctionValue;
            $totalMustValue = $this->getTotalRequiredValue($remainValue, $propQtyMust);
            $totalValue = $this->getTotalValue($correctionValue, $totalMustValue);

            return $totalValue;
        }

        return false;
    }
}
