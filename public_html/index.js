$(function() {
    $.ajax({
        url: 'http://localhost/state',
        context: document.body
    }).done( function(data) {
        const $hanoi = $('#hanoi');

        if( typeof data.pegs !== 'undefined' ) {
            $hanoi.html('');

            for( peg of data.pegs ) {
                const $peg = $('<div class="peg"></div>');
                const $disks = $('<div class="disks"></div>');

                // console.log(peg);
                for( disk of peg.disks ) {
                    console.log(disk);
                }

                $peg.append($disks);
                $peg.append('<a href="#" class="button">From</a>');
                $hanoi.append($peg);
            }
        }
    })
});
