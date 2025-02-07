<?php

function inventoryStatus($quantities, $material) {
    $status = 0;
    foreach ($quantities as $quantity) {
        if($quantity->material_id == $material->id){
            $status += $quantity->quantity;
        }
    }
    return $status;
}

