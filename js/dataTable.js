// Table to vechicle list
$(document).ready(function () {
  $('#listClientsVehicles').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

$(document).ready(function () {
  $('#listCompanys').DataTable({
    scrollY: '50vh',
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

$(document).ready(function () {
  $('#listSections').DataTable({
    paging: false,
    autoWidth: false,
    scrollY: '15rem',
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})

$(document).ready(function () {
  $('#listDashboardMovements').DataTable({
    paging: false,
    scrollY: '10rem',
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

$(document).ready(function () {
  $('#checkinCancel').DataTable({
    scrollY: '20rem',
    search: {
      search: ''
    },
    stateSave: true,

    scrollCollapse: true,
    paging: false,
    // info: false,
    ordering: false,
    autoWidth: false,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})
$(document).ready(function () {
  $('#checkoutCancel').DataTable({
    scrollY: '16rem',
    search: {
      search: ''
    },
    stateSave: true,

    scrollCollapse: true,
    paging: false,
    // info: false,
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
    scrollY: '16rem',
    scrollCollapse: true,
    // paging: false,
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

$(document).ready(function () {
  $('#listCheckoutVehicles').DataTable({
    scrollCollapse: true,
    info: false,
    ordering: false,
    autoWidth: false,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    }
  })
})
