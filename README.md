# Hanoi Challenge

An implementation of [Tower Of Hanoi](https://en.wikipedia.org/wiki/Tower_of_Hanoi) using PHP Slim. There is a nifty front end for testing.

## Running

Run ```composer install``` to install dependencies. Add a .env file based on [.env.example](./.env.example) and then ```docker compose up``` to start the server. If you are not using this on Docker, it will just use the defaults (maybe a TODO  there).

The game will now be at [localhost](http://localhost/).

If you wish to change the number of disks, pegs or the location of the state storage file, change ```.env``` accordingly. It is possible to run with only one peg but you won't get very far, as is the case with more disks than pegs!

## Playing

To move a disk from one peg to another, click **From** under the peg to move it from, and then **To** and the destination. You will be warned if the move is invalid.

There will be a small celebration if you complete the game.

To reset the game to the initial condition, click **Reset**. You should do this after changing the number of pegs or disks, although it should sort itself out.

There is an algorithm for completing the game in the shortest number of moves, and if you don't fancy working it out you can click the auto button to run through this, although it's not quite right if you have made some moves already (weird bug!). It also only uses three pegs, so you'll need at least this number.

## Notes

I'd never used PHP ```serialize``` functionality before, so it was nice to learn that. For some reason, I needed to Base64 encode it in the file.

The original intention had been to complete this task using functional programming, but I felt that learning this paradigm and producing a suitably competent codebase would have taken much more time than I could justify. One day I will try again :-)
