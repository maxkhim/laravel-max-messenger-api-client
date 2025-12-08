<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Dialogs;

abstract class AbstractDialog
{
    protected array $steps = [];
    protected int $currentStep = 0;
    protected array $userData = [];

    abstract public function start(string $userId): string;
    public function handleInput(string $userId, string $input): ?string
    {
        if (isset($this->steps[$this->currentStep])) {
            $this->userData[$this->currentStep] = $input;
            $this->currentStep++;

            if ($this->currentStep < count($this->steps)) {
                return $this->steps[$this->currentStep]['question'];
            } else {
                return $this->finalize($userId);
            }
        }

        return null;
    }

    abstract protected function finalize(string $userId): string;
}
