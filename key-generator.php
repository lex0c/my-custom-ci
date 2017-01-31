<?php

/**
 * PHP Alias for Create Keys.
 */
echo 'Your key: ' . substr(base64_encode(uniqid(mt_rand(), true)), 0, 42) . "\n";
