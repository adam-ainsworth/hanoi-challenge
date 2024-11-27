<?php

declare(strict_types=1);

namespace AdamAinsworth\HanoiChallenge;

class Hanoi {
    private $pegs;
    private $completed;

    public function __construct() {
        $this->completed = false;

        for($i = 0; $i < NUMBER_PEGS; $i++) {
            $this->pegs[] = new Peg($i + 1, ($i === 0 ? NUMBER_DISKS : 0) );
        }

        $this->save();
    }

    public function __serialize() {
        return [
            'pegs'      => $this->pegs,
            'completed' => $this->completed,
        ];
    }

    public function __unserialize($data) {
        $this->pegs = $data['pegs'];
        $this->completed = $data['completed'];
    }

    public static function create() {
        if( file_exists(STATE_JSON) ) {
            $data = base64_decode(file_get_contents(STATE_JSON));
            $hanoi = unserialize($data);
        
            if( isset($hanoi->pegs) && (count($hanoi->pegs) === NUMBER_PEGS) ) {
                $disk_count = 0;
        
                foreach($hanoi->pegs as $peg) {
                    $disk_count += $peg->disk_count();
                }
        
                if( $disk_count === NUMBER_DISKS ) {
                    return $hanoi;
                }
            }
        }

        return new Hanoi();
    }

    public function save() : void {
        $output = base64_encode(serialize($this));

        file_put_contents(STATE_JSON, $output);
    }

    public function move(int $from, int $to) : bool {
        // check they are valid pegs
        if( $from < 1 || $from > NUMBER_PEGS || $to < 1 || $to > NUMBER_PEGS ) {
            return false;
        }

        // reduce the indexes as the front end is as 1-indexed
        $from_peg = $this->pegs[--$from];
        $to_peg = $this->pegs[--$to];

        // check we have a disk to move from
        if( $from_peg->disk_count() === 0 ) {
            return false;
        }

        $disk_to_move = $from_peg->top_disk();
        // check we have a disk to move from
        if( $to_peg->disk_count() > 0 && $to_peg->top_disk()->size() > $disk_to_move->size() ) {
            $from_peg->add_disk($disk_to_move);

            return false;
        }

        // TODO check if completed

        // seems fine, let's do the move
        $to_peg->add_disk($disk_to_move);
        $this->save();

        return true;
    }

    public function auto() : bool {
        return true;
    }

    public function return_state() : string {
        return json_encode([
            'completed' => $this->completed,
            'pegs' => array_map( function(Peg $peg) {
                return $peg->return_state();
            }, $this->pegs)
        ]);
    }
}
