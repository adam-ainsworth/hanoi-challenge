$(function() {
    $('#reset').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'http://localhost/reset',
            context: document.body
        }).done( update );
    });

    $('#auto').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'http://localhost/auto',
            context: document.body
        }).done( update );
    });

    function update() {
        $.ajax({
            url: 'http://localhost/state',
            context: document.body
        }).done( function(data) {
            const $hanoi = $('#hanoi');
    
            if( typeof data.pegs !== 'undefined' ) {
                $('#peg-button').off('click');
            
                $hanoi.html('');
    
                for( peg of data.pegs ) {
                    const $peg = $('<div class="peg"></div>');
                    const $disks = $('<div class="disks"></div>');
    
                    for( disk of peg.disks ) {
                        const $disk = $('<div class="disk" style="width: ' + ( 20 + disk.size * 10) + '%; background-color: ' + disk.colour + ';">' + disk.name + '</div>')
    
                        $disks.append($disk);
                    }
    
                    $peg.append($disks);
                    $peg.append('<a href="#" class="button peg-button" data-index="' + peg.index + '">From</a>');
                    $hanoi.append($peg);
                }

                $('.peg-button').on('click', function(e) {
                    e.preventDefault();
            
                    const $button = $(e.target);
            
                    console.log( $button.data('index') );
                });                
            }
        });
    }

    update();
});
