<div class="container">

  <div class="row m-t">
    <div class="col-sm-12">
     
       <nav class="navbar navbar-default card-box sub-navbar">
        <div class="container-fluid">

          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-title-navbar" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand no-link" href="javascript:void(0);">{{ trans('global.admin') }}</a>
            <a class="navbar-brand no-link" href="javascript:void(0);">\</a>
            <a class="navbar-brand no-link" href="javascript:void(0);">{{ trans('global.users') }}</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-title-navbar">

            <div class="navbar-form navbar-right">
                <a href="#/admin/user" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('global.add_new_user') }}</a>
            </div>

          </div>
        </div>
      </nav>
    
    </div>
  </div>

  <script>
var admin_users_table = $('#dt-table-admin_users').DataTable({
  ajax: "{{ url('platform/admin/users/data') }}",
  order: [
<?php if (\Gate::allows('owner-management')) { ?>
    [0, "asc"],
    [1, "asc"]
<?php } else { ?>
    [0, "asc"]
<?php } ?>
  ],
  dom: "<'row'<'col-sm-12 dt-header'<'pull-left'lr><'pull-right'f><'pull-right hidden-sm hidden-xs'T><'clearfix'>>>t<'row'<'col-sm-12 dt-footer'<'pull-left'i><'pull-right'p><'clearfix'>>>",
  processing: true,
  serverSide: true,
  stateSave: true,
  responsive: true,
  stripeClasses: [],
  lengthMenu: [
    [10, 25, 50, 75, 100, 1000000],
    [10, 25, 50, 75, 100, "{{ trans('global.all') }}"]
  ],
  columns: [<?php if (\Gate::allows('owner-management')) { ?>{
    data: "reseller"
  }, <?php } ?>{
    data: "name"
  }, {
    data: "email"
  }, {
    data: "plan",
    sortable: false
  }, {
    data: "role",
    sortable: false
  }, {
    data: "logins"
  }, {
    data: "last_login",
    width: 120
  }, {
    data: "created_at",
    width: 120
  }, {
    data: "active",
    width: 60
  }, {
    data: "sl",
    width: 74,
    sortable: false
  }],
  fnDrawCallback: function() {
    onDataTableLoad();
  },
  columnDefs: [
<?php if (\Gate::allows('owner-management')) { ?>
    {
      render: function (data, type, row) {
        return '<img src="' + row.favicon + '" style="height:16px;float: left;margin: 1px 4px;"> ' + row.reseller;
      },
      targets: 0
    },
<?php } ?>
    {
      render: function (data, type, row) {
        return '<div data-moment="fromNowDateTime">' + data + '</div>';
      },
      targets: [<?php echo (\Gate::allows('owner-management')) ? '6, 7' : '5, 6'; ?>] /* Column to re-render */
    },
    {
      render: function (data, type, row) {
        return '<div class="text-center">' + data + '</div>';
      },
      targets: [<?php echo (\Gate::allows('owner-management')) ? '5' : '4'; ?>] /* Column to re-render */
    },
    {
      render: function (data, type, row) {
        if(row.role_name != 'user') {
          return '<strong>' + row.role + '</strong>';
        } else {
          return row.role;
        }
      },
      targets: <?php echo (\Gate::allows('owner-management')) ? '4' : '3'; ?>
    },
    {
      render: function (data, type, row) {
        if(data == 1) {
          return '<div class="text-center"><i class="fa fa-check" aria-hidden="true"></i></div>';
        } else {
          return '<div class="text-center"><i class="fa fa-times" aria-hidden="true"></i></div>';
        }
      },
      targets: <?php echo (\Gate::allows('owner-management')) ? '8' : '7'; ?>
    },
    {
      render: function (data, type, row) {
        var disabled = (row.undeletable == '1') ? ' disabled' : '';
        var btn_delete = (disabled) ? '' : ' row-btn-delete';
        return '<div class="row-actions-wrap"><div class="text-center row-actions" data-sl="' + data + '">' + 
          '<a href="<?php echo url('platform/admin/user/login-as') ?>/' + data + '" class="btn btn-xs btn-primary row-btn-login" data-toggle="tooltip" title="{{ trans('global.login') }}"><i class="fa fa-sign-in"></i></a> ' + 
          '<a href="#/admin/user/' + data + '" class="btn btn-xs btn-success row-btn-edit" data-toggle="tooltip" title="{{ trans('global.edit') }}"><i class="fa fa-pencil"></i></a> ' + 
          '<a href="javascript:void(0);" class="btn btn-xs btn-danger' + btn_delete + '" data-toggle="tooltip" title="{{ trans('global.delete') }}"' + disabled + '><i class="fa fa-trash"></i></a>' + 
          '</div></div>';
      },
      targets: <?php echo (\Gate::allows('owner-management')) ? '9' : '8'; ?> /* Column to re-render */
    },
  ],
  language: {
    search: "",
    emptyTable: "{{ trans('global.empty_table') }}",
    info: "{{ trans('global.dt_info') }}",
    infoEmpty: "",
    infoFiltered: "(filtered from _MAX_ total entries)",
    thousands: "{{ trans('i18n.thousands_sep') }}",
    lengthMenu: "{{ trans('global.show_records') }}",
    processing: '<i class="fa fa-circle-o-notch fa-spin"></i>',
    paginate: {
      first: '<i class="fa fa-fast-backward"></i>',
      last: '<i class="fa fa-fast-forward"></i>',
      next: '<i class="fa fa-caret-right"></i>',
      previous: '<i class="fa fa-caret-left"></i>'
    }
  }
});

$('#dt-table-admin_users_wrapper .dataTables_filter input').attr('placeholder', "{{ trans('global.search_') }}");

</script>
  <div class="row">
  <div class="col-sm-12">
    <div class="card-box table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dt-table-admin_users" style="width:100%">
      <thead>
      <tr>
<?php if (\Gate::allows('owner-management')) { ?><th>{{ trans('global.reseller') }}</th><?php } ?>
        <th>{{ trans('global.name') }}</th>
        <th>{{ trans('global.email') }}</th>
        <th>{{ trans('global.plan') }}</th>
        <th>{{ trans('global.role') }}</th>
        <th class="text-center">{{ trans('global.logins') }}</th>
        <th>{{ trans('global.last_login') }}</th>
        <th>{{ trans('global.created') }}</th>
        <th class="text-center">{{ trans('global.active') }}</th>
        <th class="text-center">{{ trans('global.actions') }}</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  </div>
  <script>

$('#dt-table-admin_users').on('click', '.row-btn-delete', function() {
  var sl = $(this).parent('.row-actions').attr('data-sl');

  swal({
    title: _lang['confirm'],
    type: "warning",
    showCancelButton: true,
    cancelButtonText: _lang['cancel'],
    confirmButtonColor: "#DD6B55",
    confirmButtonText: _lang['yes_delete']
  }, 
  function(){
    blockUI();

    var jqxhr = $.ajax({
      url: "{{ url('platform/admin/user/delete') }}",
      data: {sl: sl,  _token: '<?= csrf_token() ?>'},
      method: 'POST'
    })
    .done(function(data) {
      if(data.result == 'success')
      {
        admin_users_table.ajax.reload();
      }
      else
      {
        swal(data.msg);
      }
    })
    .fail(function() {
      console.log('error');
    })
    .always(function() {
      unblockUI();
    });
  });
});

</script> 
</div>
<!-- end container --> 