<?php
function is_blank($value, $zero = false){
    if($value == null || empty($value)) return true;
    if($zero && $value == 0) return true; 
    return false;
}
