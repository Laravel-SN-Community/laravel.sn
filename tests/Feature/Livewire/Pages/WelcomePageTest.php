<?php

it('can render the welcome page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
