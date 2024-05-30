<?php
/** @var \MODX\Revolution\modX $modx */

if ($modx->services->has('mmxUsers')) {
    /** @var array $scriptProperties */
    return $modx->services->get('mmxUsers')->handleSnippet($scriptProperties);
}