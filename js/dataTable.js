$(document).ready(function() {
  $('#listClientsVehicles').DataTable({
      "language": {
          "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
      }
  });
});



$(document).ready(function() {
  $('#listDashboard').DataTable({
      scrollY: '15rem',
      scrollX: '40rem',
      scrollCollapse: true,
      paging: false,
      searching: false,
      info: false,
      ordering: false,
      "autoWidth": false,
      "language": {
          "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
      },
      
  });
});


