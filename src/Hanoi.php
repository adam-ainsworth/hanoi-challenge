<?php

declare(strict_types=1);

namespace AdamAinsworth\HanoiChallenge;

class Hanoi {
    private $pegs;
    private $completed;
    private $moves;

    public function __construct() {
        $this->completed = false;
        $this->moves = 0;

        for($i = 0; $i < NUMBER_PEGS; $i++) {
            $this->pegs[] = new Peg($i, ($i === 0 ? NUMBER_DISKS : 0) );
        }

        $this->save();
    }

    public function __serialize() {
        return [
            'pegs'      => $this->pegs,
            'completed' => $this->completed,
            'moves'      => $this->moves,
        ];
    }

    public function __unserialize($data) {
        $this->pegs = $data['pegs'];
        $this->completed = $data['completed'];
        $this->moves = $data['moves'];
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

    public function check(Peg $from_peg, Peg $to_peg) : bool {
        if( $from_peg->disk_count() === 0 ) {
            return false;
        }

        // check it's a valid move
        if( $from_peg->top_size() > $to_peg->top_size() ) {
            return false;
        }

        return true;
    }

    public function move(int $from, int $to) : int {
        // game is already completed
        if( $this->completed === true ) {
            return -4;
        }

        // check they are valid pegs
        if( $from < 0 || $from >= NUMBER_PEGS || $to < 0 || $to >= NUMBER_PEGS ) {
            return -1;
        }

        $from_peg = $this->pegs[$from];
        $to_peg = $this->pegs[$to];

        return $this->do_move($from_peg, $to_peg);
    }

    public function do_move(Peg $from_peg, Peg $to_peg) : int {
        // check it's a valid move
        if( ! $this->check($from_peg, $to_peg) ) {
            return -2;
        }

        // seems fine, let's do the move
        $disk_to_move = $from_peg->pop_disk();
        $to_peg->add_disk($disk_to_move);

        // increase move count for the auto function
        $this->moves++;

        if( $to_peg->get_index() > 0 && $to_peg->disk_count() === NUMBER_DISKS ) {
            $this->completed = true;
        }

        $this->save();

        return 0;
    }

    public function auto() : int {
        // game is already completed
        if( $this->completed === true ) {
            return -4;
        }

        switch( $this->moves % 3) {
            case 0:
                $peg_a = $this->pegs[0];
                $peg_b = $this->pegs[1];
                break;
            case 1:
                $peg_a = $this->pegs[0];
                $peg_b = $this->pegs[2];
                break;
            case 2:
                $peg_a = $this->pegs[1];
                $peg_b = $this->pegs[2];
                break;
        }

        if( $this->check($peg_a, $peg_b) ) {
            return $this->do_move($peg_a, $peg_b);
        } else {
            return $this->do_move($peg_b, $peg_a);
        }
    }

    public function return_state() : string {
        return json_encode([
            'moves' => $this->moves,
            'completed' => $this->completed,
            'pegs' => array_map( function(Peg $peg) {
                return $peg->return_state();
            }, $this->pegs)
        ]);
    }
}
