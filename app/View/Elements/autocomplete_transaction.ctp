<script type="text/javascript">
$(document).ready(function() {
  var firstId = '<?php echo $firstId; ?>';
  var secondId = JSON.parse('<?php echo $secondId; ?>');
  var model = JSON.parse('<?php echo $model; ?>');
  var controller = '<?php echo $controller; ?>';
  var action = '<?php echo $action; ?>';
  var fields = JSON.parse('<?php echo $fields; ?>');

  function log( message ) {
    $( "<div>" ).text( message ).prependTo( "#log" );
    $( "#log" ).scrollTop( 0 );
  }

  var mappingID = {};
  var mappingCId = {};
  var mappingCN = {};
  var mappingBP = {};
  $( "#" + firstId ).autocomplete({
    source: function( request, response ) {
    $.ajax({
    url:'<?= $this->Html->url(array('controller' => $controller, 'action'=> $action)); ?>/',

    data: {term: request.term},
    success: function( data ) {
      if(data != 'no') {
      var autos = new Array();
      result = JSON.parse(data);
      for (x in result){
        autos.push(result[x][model[0]][fields[1]]);
        mappingID[result[x][model[0]][fields[1]]] = result[x][model[0]][fields[0]];
        mappingCId[result[x][model[0]][fields[1]]] = result[x][model[0]][fields[2]];
        mappingBP[result[x][model[0]][fields[1]]] = result[x][model[0]][fields[4]];
        mappingCN[result[x][model[0]][fields[1]]] = result[x][model[1]][fields[3]];
      }

      response( autos );
      }
    }
    });
    },
    minLength: 3,
    select: function( event, ui ) {
    $('#' + secondId[0]).val(mappingID[ui.item.label]);
    $('#' + secondId[1]).val(mappingCId[ui.item.label]);
    $('#' + secondId[2]).val(mappingCN[ui.item.label]);
    $('#' + secondId[3]).val(mappingBP[ui.item.label]);

      log( ui.item ?
        "Selected: " + ui.item.label :
                  "Nothing selected, input was " + this.value);
      },
    open: function() {
      $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
    },
    close: function() {
      $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
    }
  });
});
</script>
