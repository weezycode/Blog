<?php

declare(strict_types=1);

namespace App\Service\Http\Session;

final class Session
{
    private array $sessionParamBag; // $_SESSION

    public function __construct()
    {

        session_start();

        $this->sessionParamBag = &$_SESSION;
    }

    public function set(string $name, mixed $value): void
    {
        $this->sessionParamBag[$name] = $value;
    }

    public function get(string $name): mixed
    {
        return isset($this->sessionParamBag[$name]) ? $this->sessionParamBag[$name] : null;
    }

    public function getAll(): ?array
    {
        return $this->sessionParamBag;
    }

    public function remove(string $name): void
    {
        unset($this->sessionParamBag[$name]);
    }

    public function addFlashes(string $type, string $message): void
    {
        $this->set('flashes', [$type => $message]);
    }

    public function getFlashes(): ?array
    {
        $flashes = $this->get('flashes');
        $this->remove('flashes');

        return $flashes;
    }
}
