<?php

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
        list(
            $this->size,
            $this->name,
            $this->colour,
        ) = unserialize($data);
    }

    public function return_state() : String {
        return json_encode( [
            'size' => $this->size,
            'name' => $this->name,
            'colour' => $this->colour,
        ] );
    }
}
