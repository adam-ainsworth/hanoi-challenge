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

                for( disk of peg.disks ) {
                    const $disk = $('<div class="disk" style="width: ' + ( 20 + disk.size * 10) + '%; background-color: ' + disk.colour + ';">' + disk.name + '</div>')

                    $disks.append($disk);
                }

                $peg.append($disks);
                $peg.append('<a href="#" class="button">From</a>');
                $hanoi.append($peg);
            }
        }
    })
});
