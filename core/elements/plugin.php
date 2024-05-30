<?php
/** @var \MODX\Revolution\modX $modx */

if ($modx->services->has('mmxUsers')) {
    $modx->services->get('mmxUsers')->handleEvent($modx->event);
}