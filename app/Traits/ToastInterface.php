<?php

namespace App\Traits;

use Flasher\Prime\FlasherInterface;

trait ToastInterface
{
    public function __construct(private FlasherInterface $flasherInterface) {}

    public function constructToastMessage(string $message, string $title, $model)
    {
            $this->flasherInterface
            ->option('position', 'top-center')
            ->option('timeout', 2500)
            ->$model(message: $message, title: $title);

            return $this->flasherInterface;
    }
}
