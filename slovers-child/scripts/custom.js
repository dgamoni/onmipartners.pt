(function($) {

    /*
     *  new_map
     *
     *  This function will render a Google Map onto the selected jQuery element
     *
     *  @type   function
     *  @date   8/11/2013
     *  @since  4.3.0
     *
     *  @param  $el (jQuery element)
     *  @return n/a
     */

    function new_map( $el ) {

        // var
        var $markers = $el.find('.marker');


        // vars
        var args = {
            zoom        : 16,
            center      : new google.maps.LatLng(0, 0),
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            styles: [
                {elementType: 'geometry', stylers: [{color: '#b0b3b5'}]},
                {elementType: 'labels.text.stroke', stylers: [{color: 'transparent'}]},
                {elementType: 'labels.text.fill', stylers: [{color: '#222d32'}]},
                {
                    featureType: 'administrative.locality',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#222d32'}]
                },
                           {
                    featureType: 'road',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#415e65'}]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'geometry',
                    stylers: [{color: '#93a1a3'}]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'geometry.stroke',
                    stylers: [{color: '#93a1a3'}]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#415e65'}]
                },
                {
                    featureType: 'transit',
                    elementType: 'geometry',
                    stylers: [{color: '#2f3948'}]
                },
                {
                    featureType: 'transit.station',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#415e65'}]
                },
                {
                    featureType: 'water',
                    elementType: 'geometry',
                    stylers: [{color: '#93a1a3'}]
                }
            ]
        };


        // create map
        var map = new google.maps.Map( $el[0], args);


        // add a markers reference
        map.markers = [];


        // add markers
        $markers.each(function(){

            add_marker( $(this), map );

        });


        // center map
        center_map( map );


        // return
        return map;

    }

    /*
     *  add_marker
     *
     *  This function will add a marker to the selected Google Map
     *
     *  @type   function
     *  @date   8/11/2013
     *  @since  4.3.0
     *
     *  @param  $marker (jQuery element)
     *  @param  map (Google Map object)
     *  @return n/a
     */

    function add_marker( $marker, map ) {

        // var
        var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

        // create marker
        var marker = new google.maps.Marker({
            position    : latlng,
            map         : map
        });

        // add to array
        map.markers.push( marker );

        // if marker contains HTML, add it to an infoWindow
        if( $marker.html() )
        {
            // create info window
            var infowindow = new google.maps.InfoWindow({
                content     : $marker.html()
            });

            // show info window when marker is clicked
            google.maps.event.addListener(marker, 'click', function() {

                infowindow.open( map, marker );

            });
        }

    }

    /*
     *  center_map
     *
     *  This function will center the map, showing all markers attached to this map
     *
     *  @type   function
     *  @date   8/11/2013
     *  @since  4.3.0
     *
     *  @param  map (Google Map object)
     *  @return n/a
     */

    function center_map( map ) {

        // vars
        var bounds = new google.maps.LatLngBounds();

        // loop through all markers and create bounds
        $.each( map.markers, function( i, marker ){

            var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

            bounds.extend( latlng );

        });

        // only 1 marker?
        if( map.markers.length == 1 )
        {
            // set center of map
            map.setCenter( bounds.getCenter() );
            map.setZoom( 16 );
        }
        else
        {
            // fit to bounds
            map.fitBounds( bounds );
        }

    }

    /*
     *  document ready
     *
     *  This function will render each map when the document is ready (page has loaded)
     *
     *  @type   function
     *  @date   8/11/2013
     *  @since  5.0.0
     *
     *  @param  n/a
     *  @return n/a
     */
// global var
    var map = null;

    $(document).ready(function(){

        $('.kc-widget-title').append('<span class="cpicon kc-icon-instagram"></span>');

        // if ($('.kc_tabs_nav').length > 0) {
        //     $('ul.kc_tabs_nav').addClass('original').clone().insertAfter('ul.kc_tabs_nav').addClass('cloned').css('position','fixed').css('top','100.06px').css('margin-top','100.06px').css('z-index','5000').removeClass('original').hide();

        //     scrollIntervalID = setInterval(stickIt, 10);


        //     function stickIt() {

        //       var orgElementPos = $('.original').offset();
        //       orgElementTop = orgElementPos.top-100.06;               

        //       if ($(window).scrollTop() >= (orgElementTop)) {
        //         // scrolled past the original position; now only show the cloned, sticky element.

        //         // Cloned element should always have same left position and width as original element.     
        //         orgElement = $('.original');
        //         coordsOrgElement = orgElement.offset();
        //         leftOrgElement = coordsOrgElement.left;  
        //         widthOrgElement = orgElement.css('width');
        //         $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
        //         $('.original').css('visibility','hidden');
        //       } else {
        //         // not scrolled past the menu; only show the original menu.
        //         $('.cloned').hide();
        //         $('.original').css('visibility','visible');
        //       }
        //     }
        // }

        $('.acf-map').each(function(){

            // create map
            map = new_map( $(this) );

        });
        $('.quantity').on('click', '.plus', function(e) {
            $input = $(this).prev('input.qty');
            var val = parseInt($input.val());
            var step = $input.attr('step');
            step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
            $input.val( val + step ).change();
        });
        $('.quantity').on('click', '.minus',
            function(e) {
                $input = $(this).next('input.qty');
                var val = parseInt($input.val());
                var step = $input.attr('step');
                step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
                if (val > 0) {
                    $input.val( val - step ).change();
                }
            });

        $('.banner a[href="#"]').on('click', function (e) {
            e.preventDefault();
        })

    });
})(jQuery);