// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
      "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
      "iDisplayLength": 50
  });

  $('#dataTable1').DataTable({
      "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
      "iDisplayLength": 25
  });  

  $('#dataTable2').DataTable({
      "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
      "iDisplayLength": 25
  });
    
  $('#dataTable3').DataTable({
    "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
    "iDisplayLength": 25
    });  

    $('#dataTable4').DataTable({
        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 50
    });  
});
