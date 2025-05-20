<?php

namespace src;

class Validate
{
    private bool $_passed = false;

    private array $_errors = [];

    private ?DB $_db;


    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = []): static
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $value) {
                $bit = trim($source[$item]);
                $item = escape($item);
                if ($rule === 'required' && empty($bit)) {
                    $this->addError("{$item} is required");
                } else if (!empty($bit)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($bit) < $value) {
                                $this->addError("{$item} must be a minimum of {$value} characters");
                            }
                        break;
                        case 'max':
                            if (strlen($bit) > $value) {
                                $this->addError("{$item} must be a maximum of {$value} characters");
                            }
                        break;
                        case 'matches':
                            if ($bit !== $source[$value]) {
                                $this->addError("{$value} must match {$item}");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($value, [$item, '=', $bit]);
                            if ($check->count()) {
                                $this->addError("{$item} already exists");
                            }
                        break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error): void
    {
        $this->_errors[] = $error;
    }

    public function errors(): array
    {
        return $this->_errors;
    }

    public function passed(): bool
    {
        return $this->_passed;
    }
}