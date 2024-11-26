<?php

namespace AdamAinsworth\HanoiChallenge;

class Disk {
    private int $size;
    private string $name;
    private string $colour; 

    public function __construct(Int $size)  {
        $this->size = $size;
        $this->name = 'disk-' . $size;
        $this->colour = '#' . str_pad( dechex(rand(0, 255)) . dechex(rand(0, 255)) . dechex(rand(0, 255)), 6, '0', STR_PAD_LEFT);
    }

    public function serialise() : String {
        return json_encode( [
            'size' => $this->size,
            'name' => $this->name,
            'colour' => $this->colour,
        ] );
    }
}
