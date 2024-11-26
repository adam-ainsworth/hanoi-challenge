<?php

namespace AdamAinsworth\HanoiChallenge;

class Hanoi {
    private $pegs;

    public function __construct() {
        for($i = 0; $i < 3; $i++) {
            $this->pegs[] = new Peg($i + 1, ($i === 0) );
        }
    }

    public static function load() : Hanoi {
        if( file_exists('./state.json') ) {
            $input = readfile('./state.json');

            $hanoi = json_decode($input);
        } else {
            $hanoi = new Hanoi();

            $hanoi->save();

            return $hanoi;
        }
    }

    public function save() : void {
        $output = $this->serialise();

        // file_put_contents('./state.json', $output);
    }

    public function serialise() : String {
        return json_encode([
            'pegs' => array_map( function(Peg $peg) {
                return $peg->serialise();
            }, $this->pegs)
        ]);
    }
}
