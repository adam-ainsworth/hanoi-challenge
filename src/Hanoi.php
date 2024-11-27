<?php

namespace AdamAinsworth\HanoiChallenge;

class Hanoi {
    private $pegs;

    public function __construct() {
        for($i = 0; $i < NUMBER_PEGS; $i++) {
            $this->pegs[] = new Peg($i + 1, ($i === 0 ? NUMBER_DISKS : 0) );
        }

        $this->save();
    }

    public function __serialize() {
        return [
            'pegs' => $this->pegs,
        ];
    }

    public function __unserialize($data) {
        $this->pegs = $data['pegs'];
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

    public function return_state() : string {
        return json_encode([
            'pegs' => array_map( function(Peg $peg) {
                return $peg->return_state();
            }, $this->pegs)
        ]);
    }
}
