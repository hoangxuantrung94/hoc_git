jQuery(document).ready(function($){

    /**
     * AJAX ACTION 
     */

    $("#opalestate_user_frontchangepass").submit(function(e) {
        var $this =  $(this);
        $('.alert',$this).remove();
        $.ajax({
            type: "POST",
            url: opalesateJS.ajaxurl,
            dataType:'json',
            data: $( this ).serialize()+"&action=opalestate_save_changepass", // serializes the form's elements.
            success: function(data) {
                if( data.status == false ){
                    $this.find('.form-table').prepend( $('<p class="alert alert-danger">'+data.message+'</p>') );
                }else {
                    $this.find('.form-table').prepend( $('<p class="alert alert-info">'+data.message+'</p>') );
                     $('input[type="text"]', $this).val( '' );

                    setTimeout( function(){
                         $('.alert',$this).remove();
                    } , 1000 );
                }
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    })
    //// ajax favorite
    $('body').delegate('.property-toggle-favorite','click', function(){
        var $this = $(this);
        if( $(this).hasClass('opalestate-need-login') ){
            $('.pbr-user-login, .opalesate-login-btn').click();
            return;
        } 
        $.ajax({
            type: "POST",
            url: opalesateJS.ajaxurl,
            data: 'property_id='+$(this).data('property-id')+'&action=opalestate_toggle_status', // serializes the form's elements.
            success: function(data) {  
                if( data ){
                    $this.replaceWith( $(data) ) ;   
                }
            }
        });
    } );

    /// ajax set featured 
    $('body').delegate('.btn-toggle-featured','click', function(){
        var $this = $(this);  

        $.ajax({
            type: "POST",
            url: opalesateJS.ajaxurl,
            data: 'property_id='+$(this).data('property-id')+'&action=opalestate_toggle_featured_property', // serializes the form's elements.
            dataType:'json',
            success: function(data) {  
                if( data.status ){
                   $('[data-id="property-toggle-featured-'+$this.data('property-id')+'"]').removeClass( 'hide');
                   $this.remove();
                }else {
                    alert( data.msg );
                }
            }
        });
        return false;
    } );
    
    //
    $(".owl-carousel-play .owl-carousel").each( function(){
        var config = {
            navigation : false, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            pagination : $(this).data( 'pagination' ),
            autoHeight: true,
            pagination : true,
         };

        var owl = $(this);
        if( $(this).data('slide') == 1 ){
            config.singleItem = true;
        }else {
            config.items = $(this).data( 'slide' );
        }
        if ($(this).data('desktop')) {
            config.itemsDesktop = $(this).data('desktop');
        }
        if ($(this).data('desktopsmall')) {
            config.itemsDesktopSmall = $(this).data('desktopsmall');
        }
        if ($(this).data('desktopsmall')) {
            config.itemsTablet = $(this).data('tablet');
        }
        if ($(this).data('tabletsmall')) {
            config.itemsTabletSmall = $(this).data('tabletsmall');
        }
        if ($(this).data('mobile')) {
            config.itemsMobile = $(this).data('mobile');
        }
        $(this).owlCarousel( config );
        $('.opalestate-left',$(this).parent()).click(function(){
              owl.trigger('owl.prev');
              return false;
        });
        $('.opalestate-right',$(this).parent()).click(function(){
            owl.trigger('owl.next');
            return false;
        });
    } );

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    $("#sync2").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
    });

    $('form.opalestate-contact-form').submit(function(){

        var data = $('form.opalestate-contact-form').serialize();

        $.ajax({
            url: opalesateJS.ajaxurl,
            type:'POST',
            dataType: 'json',
            data:  'action=send_email_contact&' + data
        }).done(function(reponse) {
            var $parent = $('form.opalestate-contact-form').parent();
            if( $parent.find('#property-contact-notify').length > 0 ){
                $parent.find('#property-contact-notify').html( reponse.msg  );
            }else {
                $('.agent-contact-form').prepend('<p id="property-contact-notify" class="'+ reponse.status +'">'+ reponse.msg +'</p>');
            }
            if(  reponse.status == "success" ){
                $('form.opalestate-contact-form .form-control').val( '' );
            }
        });

        return false;
    });

    /**
     *
     */
    $('.list-property-status li').click( function(){  
        $(".opalestate-search-form [name=status]").val( $(this).data('id') );
        $('.list-property-status li').removeClass( 'active' );
        $(this).addClass( 'active' );
    } );
    if(  $(".opalestate-search-form [name=status]").val() > 0 ){
        var id = $(".opalestate-search-form [name=status]").val();
        $('.list-property-status li').removeClass( 'active' );
        $('.list-property-status [data-id='+id+']').addClass( 'active' );
    }

    /*-----------------------------------------------------------------------------------*/
    $( ".opal-slide-ranger" ).each(  function(){

      var _this = this;
      var unit = $(this).data( "unit" );
      var decimals = $(this).data( "decimals" );
      var min = $( '.slide-ranger-bar', this ).data('min');
      var max = $( '.slide-ranger-bar', this  ).data('max');

      var imin = $( '.slide-ranger-min-input', this ).val();
      var imax = $( '.slide-ranger-max-input', this ).val();
       $(".slide-ranger-bar",this).noUiSlider({
              range: {
                  'min': [ min ],
                  'max': [ max ]
              },
              start: [imin, imax],
                   connect:true,
                   serialization:{
                       lower: [
                     $.Link({
                      target: function(val) {

                        $(".slide-ranger-min-label", _this).text(val);
                        val = val.replace( unit,"");
                        $(".slide-ranger-min-input", _this).val(val);
                      }
                    })],
               upper: [
                      $.Link({
                      target: function( val ) {
                        $(".slide-ranger-max-label", _this).text(val);
                        val = val.replace( unit,"");
                        $(".slide-ranger-max-input", _this).val(val);
                      }
                    })],
               format: {
                      decimals: decimals,
                      prefix: unit,
                      suffix: unit
              }}
            });
   } );

    /*----------------*/
    $("#opalestate-sortable-form select").change( function(){
       $(this).parent().submit();
    } );
    /*-----------------------------------------------------------------------------------*/

    /**
     * Agent Map
     */
    function initialize_agent_map( data ){

        var propertyMarkerInfo = data; 
        var enable  = true ;
        var url     = propertyMarkerInfo.icon;   
        var size    = new google.maps.Size( 36, 57 );
       

        var allMarkers = []; 
        /**
         *
         */

        var  createMarker = function ( position, icon ) {
            
            var image   = {
                url: icon,
                size: size,
                scaledSize: new google.maps.Size( 36, 57 ),
                origin: new google.maps.Point( 0, 0 ),
                anchor: new google.maps.Point( 21, 56 )
            };

            marker = new google.maps.Marker({
                map: propertyMap,
                position: position,
                icon: image
            });
            return marker; 
        }
        var setMapOnAll = function (markers, map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap( map );
            }
        }
        // retina
        if( window.devicePixelRatio > 1.5 ) {
            if ( propertyMarkerInfo.retinaIcon ) {
                url = propertyMarkerInfo.retinaIcon;
                size = new google.maps.Size( 83, 113 );
            }
        }
        
        var propertyLocation = new google.maps.LatLng( propertyMarkerInfo.latitude, propertyMarkerInfo.longitude  );
        var propertyMapOptions = {
            center: propertyLocation,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        var propertyMap = new google.maps.Map( document.getElementById( "agent-map" ), propertyMapOptions );
        var infowindow = new google.maps.InfoWindow();
        createMarker( propertyLocation, url ); 

    }
    if( $("#agent-map").length > 0 ){
        initialize_agent_map( $("#agent-map").data() );
    }     


    /**
     * GOOGLE MAPS IN SINGLE PROPERTY PAGE
     */
     /* Property Detail Page - Google Map for Property Location */
    function initialize_property_map( data ){

        var propertyMarkerInfo = data; 
        var enable  = true ;
        var url     = propertyMarkerInfo.icon;   
        var size    = new google.maps.Size( 42, 57 );
       

        var allMarkers = []; 
        
        var setMapOnAll = function (markers, map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap( map );
            }
        }
        // retina
        if( window.devicePixelRatio > 1.5 ) {
            if ( propertyMarkerInfo.retinaIcon ) {
                url = propertyMarkerInfo.retinaIcon;
                size = new google.maps.Size( 83, 113 );
            }
        }
        
        var propertyLocation = new google.maps.LatLng( propertyMarkerInfo.latitude, propertyMarkerInfo.longitude );
        var propertyMapOptions = {
            center: propertyLocation,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        var propertyMap = new google.maps.Map( document.getElementById( "property-map" ), propertyMapOptions );

        /**
         *
         */

        var  createMarker = function ( position, icon ) {
            
            var image   = {
                url: icon,
                size: size,
                scaledSize: new google.maps.Size( 32, 57 ),
                origin: new google.maps.Point( 0, 0 ),
                anchor: new google.maps.Point( 21, 56 )
            };

            marker = new google.maps.Marker({
                map: propertyMap,
                position: position,
                icon: image
            });
            return marker; 
        }

        
        var infowindow = new google.maps.InfoWindow();
        createMarker( propertyLocation, url ); 

        /**
         *  Places near with actived types 
         */

        if( enable ){
            
       
            $('#property-search-places .btn-map-search').unbind('click').bind( 'click', function(){
                var service = new google.maps.places.PlacesService( propertyMap ) ;
                var type = $(this).data('type');
                var $this = $(this).parent();

                var icon   = {
                    url:  opalesateJS.mapiconurl+$(this).data('icon'),
                     scaledSize: new google.maps.Size( 28, 28 ),
                     anchor: new google.maps.Point( 21, 16 ),
                     origin: new google.maps.Point( 0, 0 )
                };

                if( !allMarkers[type] || allMarkers[type].length <= 0 ){
                    var markers = [] ;
                    var bounds    = propertyMap.getBounds();
                    
                    var $this =  $(this);

                    service.nearbySearch({
                            location: propertyLocation,
                            radius: 2000,
                            bounds: bounds,
                            type: [type]
                    },  function ( results, status ){
                            if (status === google.maps.places.PlacesServiceStatus.OK) { 
                                for (var i = 0; i < results.length; i++) {
                                    var place = results[i];
                                    var marker = new google.maps.Marker({
                                        map: propertyMap,
                                        position: place.geometry.location,
                                        icon: icon,
                                         visible: true
                                    });

                                    marker.setMap( propertyMap  ); 

                                    google.maps.event.addListener(marker, 'click', function() {

                                        infowindow.setContent( place.name );
                                        infowindow.open(propertyMap, this);
                                    });

                                    markers.push( marker );
                                }
                                 $('.nearby-counter',$this).remove();
                                $('span',$this).append( $('<em class="nearby-counter">'+markers.length+'</em>') );
                                allMarkers[type] = markers;
                                console.log( place );
                            }
                        });
                }else {
                   for( var i=0 ; i < allMarkers[type].length; i++ ){
                         allMarkers[type][i].setMap( null  ); 
                   }
                   allMarkers[type] = [];
                }

                $(this).toggleClass('active');
            } );
        } 
    }
    
    function initialize_property_street_view( data ){
        var propertyMarkerInfo = data; 
        var propertyLocation = new google.maps.LatLng( propertyMarkerInfo.latitude, propertyMarkerInfo.longitude );
        /**
         * Street View
         */
        var panoramaOptions = {
            position: propertyLocation,
            pov: {
                heading: 34,
                pitch: 10
            }
        };
       
        panorama = new google.maps.StreetViewPanorama(document.getElementById('property-street-view-map'), panoramaOptions);  
            

    } 

    //////
    var propertyLocation = null ;
    if( $("#property-map").length > 0 ){
        initialize_property_map( $("#property-map").data() );
    }
 

    // window.onload = initialize_property_map();
    $(".google-map-tabs li a").unbind('click').click( function(){  
        if( $(this).attr('href') == "#tab-google-map" ){
          setTimeout( function(){
              initialize_property_map( $("#property-map").data() );
          } , 300);
        }else if( $(this).hasClass('tab-google-street-view-btn') ){ 
             $('#property-search-places .btn-map-search').removeClass( 'active' );
            setTimeout( function(){
                initialize_property_street_view( $("#property-map").data() );
            } , 300);
        }
        $(this).parent().parent().find('li').removeClass('active');
        $(this).parent().addClass('active');

        $(this).parent().parent().find('a').each( function(){
            $( $(this).attr('href') ).removeClass('active').removeClass('in').addClass('out');
        } );
        $( $(this).attr('href') ).addClass('active').addClass('in');
        return false;
    } );

       

    /**
     * GOOGLE MAPS IN SEARCH PROPERTY PAGE 
     */
    if( $('#opalestate-map-preview').length > 0 ) {

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: opalesateJS.ajaxurl,
            data:  location.search.substr(1)+"&action=opalestate_ajx_get_properties",
            success: function(data) {
               initializePropertiesMap( data );
            }
        });
    }

    function initializePropertiesMap( properties ) {

            // Properties Array

            var mapOptions = {
                zoom: 12,
                maxZoom: 16,
                scrollwheel: false,
                 mapTypeId: google.maps.MapTypeId.ROADMAP,
                panControl: false,
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: true,
                overviewMapControl: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL,
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };

            var map = new google.maps.Map( document.getElementById( "opalestate-map-preview" ), mapOptions );

            var bounds = new google.maps.LatLngBounds();

            // Loop to generate marker and infowindow based on properties array
            var markers = new Array();

            for ( var i=0; i < properties.length; i++ ) {

                // console.log( properties[i] );
                var url = properties[i].icon;
                var size = new google.maps.Size( 42, 57 );
                if( window.devicePixelRatio > 1.5 ) {
                    if ( properties[i].retinaIcon ) {
                        url = properties[i].retinaIcon;
                        size = new google.maps.Size( 83, 113 );
                    }
                }

                var image = {
                    url: url,
                    size: size,
                    scaledSize: new google.maps.Size( 30, 51 ),
                    origin: new google.maps.Point( 0, 0 ),
                    anchor: new google.maps.Point( 21, 56 )
                };

                markers[i] = new google.maps.Marker({
                    position: new google.maps.LatLng( properties[i].lat, properties[i].lng ),
                    map: map,
                    icon: image,
                    title: properties[i].title,
                    animation: google.maps.Animation.DROP,
                    visible: true
                });

                bounds.extend( markers[i].getPosition() );

                var boxText = document.createElement( "div" );
                var pricelabel = '';

                if( properties[i].pricelabel ){
                     pricelabel = ' / ' + properties[i].pricelabel;
                }

                boxText.className = 'map-info-preview media';
                boxText.innerHTML = '<div class="media-left"><a class="thumb-link" href="' + properties[i].url + '">' +
                                        '<img class="prop-thumb" src="' + properties[i].thumb + '" alt="' + properties[i].title + '"/>' +
                                        '</a></div>' +
                                        '<div class="info-container media-body"><span class="property-status">' + properties[i].status +
                                        '</span><h5 class="prop-title"><a class="title-link" href="' + properties[i].url + '">' + properties[i].title +
                                        '</a></h5><p class="prop-address"><em>' + properties[i].address + '</em></p><p><span class="price text-primary">' + properties[i].pricehtml + pricelabel +
                                        '</span></p></div><ul class="list-inline property-meta-list"><li><i class="icon-property-amountrooms"></i>' + properties[i].amountrooms.value +
                                        '<span class="label-property">' + properties[i].amountrooms.label + '</span></li><li><i class="icon-property-bathrooms"></i>' + properties[i].bathrooms.value +
                                        '<span class="label-property">' + properties[i].bathrooms.label + '</span></li><li><i class="icon-property-bedrooms"></i>' + properties[i].bedrooms.value +
                                        '<span class="label-property">' + properties[i].bedrooms.label + '</span></li><li><i class="icon-property-parking"></i>' + properties[i].parking.value +
                                        '<span class="label-property">' + properties[i].parking.label + '</span></li></ul><div class="arrow-down"></div>';

                var myOptions = {
                    content: boxText,
                    disableAutoPan: true,
                    maxWidth: 0,
                    alignBottom: true,
                    pixelOffset: new google.maps.Size( -122, -48 ),
                    zIndex: null,
                    closeBoxMargin: "0 0 -16px -16px",
                    closeBoxURL: opalesateJS.mapiconurl+"close.png",
                    infoBoxClearance: new google.maps.Size( 1, 1 ),
                    isHidden: false,
                    pane: "floatPane",
                    enableEventPropagation: false
                };

                var ib = new InfoBox( myOptions );

                attachInfoBoxToMarker( map, markers[i], ib );
            }

            map.fitBounds(bounds);

            /* Marker Clusters */
            var markerClustererOptions = {
                ignoreHidden: true,
                maxZoom: 14,
                styles: [{
                    textColor: '#000000',
                    url: opalesateJS.mapiconurl+"cluster-icon.png",
                    height: 51,
                    width: 30
                }]
            };

            var markerClusterer = new MarkerClusterer( map, markers, markerClustererOptions );

            function attachInfoBoxToMarker( map, marker, infoBox ){
                google.maps.event.addListener( marker, 'click', function(){
                    var scale = Math.pow( 2, map.getZoom() );
                    var offsety = ( (100/scale) || 0 );
                    var projection = map.getProjection();
                    var markerPosition = marker.getPosition();
                    var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
                    var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
                    var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
                    map.setCenter( aboveMarkerLatLng );
                    infoBox.open( map, marker );
                });
            }

        }

    jQuery(".box-info").fitVids();


    ///
    $("#property-filter-status .status-item").click( function(){
        $('#property-filter-status input').val( $(this).data('id') );
        $('#property-filter-status form').submit();
    } );
    /* end */
});