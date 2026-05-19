<?php

it('root redirects to dashboard', function () {
    $this->get('/')->assertRedirect(route('dashboard'));
});
