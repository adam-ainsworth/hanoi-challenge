# Hanoi Challenge

An implementation of [Tower Of Hanoi](https://en.wikipedia.org/wiki/Tower_of_Hanoi) using PHP Slim. There is a nifty front end for testing.

## Running

Run ```composer install``` to install dependencies. Then ```docker compose up``` to start the server.

If you wish to change the number of disks, pegs or the location of the state storage file, add a file named ```.env``` in the project root and restart docker;

```
STATE_JSON='/tmp/state.json'
NUMBER_PEGS=3
NUMBER_DISKS=5
```

## Playing

To move a disk from one peg to another, click **From** under the peg to move it from, and then **To** and the destination. You will be warned if the move is invalid.

There will be a small celebration if you complete the game.

## Notes

There is an algorithm for completing the game in the shortest number of moves - I'll implement it when I have time. Also, if I'd had more time, I would have used value objects instead of lazily passing around primitive types. Building Composer within Docker would also have been desirable.

I'd never used PHP ```serialize``` functionality before, so it was nice to learn that. For some reason, I needed to Base64 encode it in the file.

The original intention had been to complete this task using functional programming, but I felt that learning this paradigm and producing a suitably competent codebase would have taken much more time than I could justify. One day I will try again :-)
