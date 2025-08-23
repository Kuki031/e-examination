<?php

namespace App\Traits;

use Flasher\Prime\FlasherInterface;

trait ToastInterface
{
    public function __construct(private FlasherInterface $flasherInterface) {}

    public function constructToastMessage(string $message, string $title, $model, int $timeout = 2500)
    {
            $this->flasherInterface
            ->option('position', 'top-center')
            ->option('timeout', $timeout)
            ->$model(message: $message, title: $title);

            return $this->flasherInterface;
    }
}
