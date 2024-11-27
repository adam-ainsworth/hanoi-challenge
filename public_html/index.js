$(function() {
    $('.button--reset,.button--restart').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'http://localhost/reset',
            context: document.body
        }).done( update );
    });

    $('.button--auto').on('click', function(e) {
        e.preventDefault();

        if( $(e.target).hasClass('disabled') ) {
            return;
        }

        alert('Auto moves are a TODO :-)');

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

                if( data.completed ) {
                    alert('CONGRATULATIONS!');

                    $('body').addClass('completed');
                    $('.peg-button,#auto').addClass('disabled');
                } else {
                    $('body').removeClass('completed');
                    $('#auto').removeClass('disabled');

                    $('.peg-button').on('click', function(e) {
                        e.preventDefault();
                
                        const $button = $(e.target), index = $button.data('index'), $hanoi = $button.closest('#hanoi'), from = $hanoi.data('from');

                        if( $button.hasClass('disabled') ) {
                            return;
                        }
                
                        if( typeof from === 'undefined' ) {
                            // this is a From click
                            $('.peg-button').text('To');
                            $button.text('From').addClass('disabled');
                            $hanoi.data('from', index);
                        } else {
                            // this is a To click
                            $('.peg-button').addClass('disabled');
                            $hanoi.removeData('from');

                            $.ajax({
                                url: 'http://localhost/move/' + from + '/' + index,
                                context: document.body
                            }).done( function(data) {
                                if( data.code === 0 ) {
                                    update();
                                } else {
                                    alert(data.message);
                                    update();
                                }
                            } );
                        }
                    });
                }                
            }
        });
    }

    update();
});
