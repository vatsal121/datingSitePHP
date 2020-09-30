<?php
function IsVariableIsSetOrEmpty($variableToCheck): bool
{
    if (!isset($variableToCheck) || empty($variableToCheck)) {
        return true;
    }
    return false;
}