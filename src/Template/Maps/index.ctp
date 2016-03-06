<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
<?= $this->Html->script('http://maps.google.com/maps/api/js?sensor=true&.js') ?>
<?= $this->Html->script('http://hpneo.github.io/gmaps/gmaps.js') ?>

<script>
$(function(){
    var map = new GMaps({
        div: '#map',
        lat: 50.44817376468559,
        lng: 30.526298122790514,
        height: 600,
        click: function(e) {
            console.log( 'lat: ' + this.getCenter().lat());
            console.log( 'lng: ' + this.getCenter().lng());
        },
        setgeometry: function(e) {
            alert('geometry');
        },
    });
m = map;
    GMaps.geolocate({
        success: function(position) {
            map.setCenter(position.coords.latitude, position.coords.longitude);
        },
        error: function(error) {
            alert('Geolocation failed: '+error.message);
        },
        not_supported: function() {
            alert("Your browser does not support geolocation");
        },
        always: function() {
//            alert("Done!");
        }
    });
/*
    map.drawOverlay({
        lat: 47.0141205,
        lng: 31.997650699999987,
        content: '<div class="overlay">We are here!</div>'
  });
    
*/
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
<h3>Twits map</h3>
<div id="map" style="height:700px; weight:100%;"></div>
</div>