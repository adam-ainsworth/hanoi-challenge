<?php

declare(strict_types=1);

namespace AdamAinsworth\HanoiChallenge;

class Disk {
    private int $size;
    private string $name;
    private string $colour; 

    public function __construct(int $size)  {
        $this->size = $size;
        $this->name = 'disk-' . $size;
        $this->colour = '#' . str_pad( dechex(rand(0, 255)) . dechex(rand(0, 255)) . dechex(rand(0, 255)), 6, '0', STR_PAD_LEFT);
    }

    public function __serialize() {
        return [
            'size'      => $this->size,
            'name'      => $this->name,
            'colour'    => $this->colour,
        ];
    }

    public function __unserialize($data) {
        $this->size = $data['size'];
        $this->name = $data['name'];
        $this->colour = $data['colour'];
    }

    public function size() : int {
        return $this->size;
    }

    public function return_state() : array {
        return [
            'size' => $this->size,
            'name' => $this->name,
            'colour' => $this->colour,
        ];
    }
}
