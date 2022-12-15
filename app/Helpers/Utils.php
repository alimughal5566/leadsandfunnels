<?php 

namespace App\Helpers;

class Utils {


    /**
     * Returns the first array from $rows (array of arrays) which has all the
     * keys and values present that are given in $values
     *
     * @param array $rows array of arrays with data
     * @param array $values array of key value pairs to search for
     * @return array first matching array or empty array if not found
     */
    public static function findFirstInRowsByValues(array $rows, array $values) : array
    {
        foreach ($rows as $index => $row) {
            if (count(array_intersect_assoc($row, $values)) === count($values)) {
                return $row;
            }
        }

        return [];
    }


    /**
     * Returns selected lp keys from request, which includes
     * 1. lp key for current funnel if 'current_hash' is received in request
     * 2. lp keys for all funnel selected in global settings if 'selected_funnels'
     * is received in request
     * 
     * Lp key is a string with funnel identifying info seperated with '~' in following order
     * 'LeadpopsVerticalId~LeadpopsSubVerticalId~LeadpopsId~LeadpopsVersionSequence'
     * 
     * @return array of lp keys
     */
    public static function getLpKeys() : array {
        // Get request instance
        $request = request();

        $keys = [];

        // If current_hash is received in request, we convert it to lp key
        $currentHash = $request->input('current_hash');
        if($currentHash){
            $keys[] = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        }

        // If selected_funnels is received, we convert it to array and merge in keys
        $selectedFunnels = $request->input('selected_funnels');
        if($selectedFunnels){
            $keys = array_merge($keys, explode(',', $selectedFunnels));
        }

        // Lastly, we make the keys unique to avoid multiple updates on same funnel
        $keys = array_unique($keys);

        return $keys;
    }

    
}