<?php

namespace AdamAinsworth\HanoiChallenge;

class Peg {
    private int $index;
    private $disks = [];

    public function __construct(Int $index, bool $add_disks)  {
        $this->index = $index;

        if( $add_disks ) {
            for($i = 0; $i < 7; $i++) {
                $this->disks[] = new Disk($i + 1);
            }
        }
    }

    public function serialise() : Array {
        return [
            'index' => $this->index,
            'disks' => array_map( function(Disk $disk) {
                return $disk->serialise();
            }, $this->disks),
        ];
    }
}
