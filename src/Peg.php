<?php

declare(strict_types=1);

namespace AdamAinsworth\HanoiChallenge;

class Peg {
    private int $index;
    private $disks = [];

    public function __construct(int $index, int $number_disks)  {
        $this->index = $index;

        for($i = 0; $i < $number_disks; $i++) {
            $this->disks[] = new Disk($i);
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

    public function disk_count() : int {
        return count($this->disks);
    }

    public function top_size() : int {
        if( $this->disk_count() === 0 ) {
            return NUMBER_DISKS;
        }

        return $this->disks[0]->size();
    }

    public function pop_disk() : Disk {
        if( $this->disk_count() > 0 ) {
            $top_disk = array_shift($this->disks);

            return $top_disk;
        }

        return null;
    }

    public function add_disk(Disk $disk) : void {
        array_unshift($this->disks, $disk);
    }

    public function return_state() : array {
        return [
            'index' => $this->index,
            'disks' => array_map( function(Disk $disk) {
                return $disk->return_state();
            }, $this->disks),
        ];
    }
}
