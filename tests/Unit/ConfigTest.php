<?php

it('defines the expected configuration keys', function () {
    $config = require __DIR__.'/../../config/vendus.php';

    expect($config)->toHaveKeys(['mode', 'api_key', 'app_url']);
});
