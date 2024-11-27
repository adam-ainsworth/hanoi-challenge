<?php

namespace AdamAinsworth\HanoiChallenge;

class Peg {
    private int $index;
    private $disks = [];

    public function __construct(int $index, int $number_disks)  {
        $this->index = $index;

        for($i = 0; $i < $number_disks; $i++) {
            $this->disks[] = new Disk($i + 1);
        }
    }

    public function __serialize() {
        return [
            'index' => $this->index,
            'disks' => $this->disks,
        ];
    }

    public function __unserialize($data) {
        $this->index = $data['index'];
        $this->disks = $data['disks'];
    }

    public function disk_count() {
        return count($this->disks);
    }

    public function return_state() : Array {
        return [
            'index' => $this->index,
            'disks' => array_map( function(Disk $disk) {
                return $disk->return_state();
            }, $this->disks),
        ];
    }
}
