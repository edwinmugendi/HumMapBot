
<div id="idMapView">
    <?php
    echo \Form::hidden('lat', $lat, array('id' => 'idLat'));
    echo \Form::hidden('lng', $lng, array('id' => 'idLng'));
    ?>
    <table class="col-md-5">
        <tr>
            <td>Type location to zoom to eg London, UK: </td>
            <td><?php echo \Form::text('zoom_to', '', array('id' => 'idZoomTo')); ?></td>
            <td>&nbsp;&nbsp;&nbsp;<button class="btn btn-danger">Zoom to</button></td>
        </tr>
    </table>

    <div id="mapCanvas"  class="commonPositionCenter">
    </div>
</div>