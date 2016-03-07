<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
<?= $this->Html->script('http://maps.google.com/maps/api/js?sensor=true&.js') ?>
<?= $this->Html->script('http://hpneo.github.io/gmaps/gmaps.js') ?>
<style>
    #popupContent {padding-top:30px}
    .overlay {display:none; position:fixed; z-index:999; opacity:0.5; filter:alpha(opacity=50); top:0; right:0; left:0; bottom:0; background:#000; }
    .popup {display:none; position:fixed; border:3px solid #999; background:#fff; width:400px; height:400px; top:50%; left:50%; margin:-100px 0 0 -100px; z-index:1000;  border-radius:10px; padding:30px;}
    .close {display:block; width:24px; text-align:center; cursor:pointer;  height:24px; line-height:24px; background:#fff; color:red; border:3px solid red;  position:absolute; top:10px; right:10px; text-decoration:none; border-radius:3px; font-size:20px; }
</style>

<script>
$(function(){
    localStorage.clear();
    var markerLat, markerLng;

    var map = new GMaps({
        div: '#map',
        lat: 50.44817376468559,
        lng: 30.526298122790514,
        height: 600,
        click: function(e) {
            markerLat = e.latLng.lat();
            markerLng = e.latLng.lng();
            
            openPopup();
/*
            console.log( 'center lat: ' + this.getCenter().lat());
            console.log( 'center lng: ' + this.getCenter().lng());

            console.log( 'lat: ' + markerLat);
            console.log( 'lng: ' + markerLng);
*/
        }
    });

    GMaps.geolocate({
        success: function(position) {
            map.setCenter(position.coords.latitude, position.coords.longitude);
        },
        error: function(error) {
            console.log('Geolocation failed: '+error.message);
        },
        not_supported: function() {
            console.log("Your browser does not support geolocation");
        },
        always: function() {
            console.log("Geolocate Done!");
        }
    });

setInterval(function(){
    getMessages();
}, 3000);

    function getMessages() {
        var slng, nlng, wlat, elat;
        wlng = map.getBounds().getSouthWest().lng();
        elng = map.getBounds().getNorthEast().lng();
        slat = map.getBounds().getSouthWest().lat();
        nlat = map.getBounds().getNorthEast().lat();
        $.ajax({
            method: "POST",
            url: "/messages/index",
            data: { wlng: wlng, 
                    elng: elng,
                    slat: slat,
                    nlat: nlat }
        })
        .done(function( data ) {
            var data = $.parseJSON(data);
            $.each(data.data, function(e,n){
                if ( !isMessageOnMap(n.id) ) {
                    addMarker(n.lat, n.lng, n.id, n.title, n.message);
                }
            })
        })
        .error(function(e){
            console.log(e);
        });
    }

    function openPopup() {
        $('#popup').show();
        $('.overlay').show();
    }

    $('.popup .close, .overlay').click(function() {
        $('.overlay, .popup').hide();
    })

    $('#send_message').on('click', function(){
        console.log($('#message').val());
        $.ajax({
            method: "POST",
            url: "/messages/add",
            data: { title: $('#title').val(), 
                    message: $('#message').val(),
                    lat: markerLat,
                    lng: markerLng }
        })
        .done(function( msg ) {
            getMessages();
            $('.overlay, .popup').hide();
        })
        .error(function(e){
            console.log(e);
        });
       $('.overlay, .popup').hide();
    });

    function addMarker(lat, lng, id, title, message) {
        map.addMarker({
            lat: lat,
            lng: lng,
            title: title,
            infoWindow: {
                content: '<p>' + message + '</p>'
            },
            click: function(e) {
                console.log('You clicked in this marker');
            }
        });
        saveMessageId(id);
    }

    function saveMessageId(id) {
        localStorage["message" + id ] = id;
        return true;
    }

    function isMessageOnMap(id) {
        if ( localStorage.getItem("message"+id) )  {
            return true;
        }
        return false;
    }

});
</script>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ( is_array($menu) ) {
                foreach ( $menu as $point => $link ) {
                    echo '<li>' . $this->Html->link(__($point), ['controller' => $link['controller'], 'action' => $link['action']]) . '</li>';
                }
            }
        ?>
    </ul>
</nav>
<div class="categories index large-9 medium-8 columns content">
<h3>Map</h3>
<div id="map" style="height:700px; weight:100%;"></div>
    <div class="overlay"></div>
    <div class="popup" id="popup">
        <span class="close">X</span>
        <div id="popupContent">
            Title: <p><input type="text" id="title" name="title" /></p>
            Message: <p><textarea id="message" rows="5" cols="10" name="text"></textarea></p>
        </div>
        <button id="send_message">Send Message</button>
    </div>
</div>