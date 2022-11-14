// Table to vechicle list
$(document).ready(function () {
  $('#listClientsVehicles').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

$(document).ready(function () {
  $('#listDashboardMovements').DataTable({
    paging: false,
    scrollY: '65vh',
    scrollCollapse: true,
    info: false,
    autoWidth: false,

    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

$(document).ready(function () {
  $('#listSelectClient').DataTable({
    scrollY: '28vh',
    scrollX: '',
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

// Table to dashboard list
$(document).ready(function () {
  $('#listDashboard').DataTable({
    scrollY: '15rem',
    scrollX: '40rem',
    scrollCollapse: true,
    paging: false,
    searching: false,
    info: false,
    ordering: false,
    autoWidth: false,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

// Table to checkin list
$(document).ready(function () {
  $('#checkin').DataTable({
    scrollY: '18rem',
    scrollCollapse: true,
    paging: false,
    info: false,
    ordering: false,
    autoWidth: false,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

$(document).ready(function () {
  $('#listVehiclesToClients').DataTable({
    scrollY: '18rem',
    scrollCollapse: true,
    info: false,
    searching: false,
    paging: false,

    autoWidth: false,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

// Table to checkout list
$(document).ready(function () {
  $('#checkout').DataTable({
    scrollCollapse: true,
    info: false,
    ordering: false,
    autoWidth: false,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})
