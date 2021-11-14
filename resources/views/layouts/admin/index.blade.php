<!DOCTYPE html>
<html lang="en">
  <head>
    @stack('styles')
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Admin Panel</title>

    <!-- vendor css -->
    <link href="{{asset('backend/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">

    <!-- toastr -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
   
    <!-- Datatable -->
    <link href="{{asset('backend/lib/highlightjs/github.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/datatables.min.css"/>

    <!-- Forms -->
    <link href="{{asset('backend/lib/spectrum/spectrum.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/summernote/summernote-bs4.css')}}" rel="stylesheet">

    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{asset('backend/css/starlight.css')}}">
  </head>
  <style>
    table.dataTable.nowrap th, table.dataTable.nowrap td {white-space: initial}
    .dataTables_wrapper .dataTables_processing {
      z-index: 9;
      background: transparent;
    }
    .table-wrapper .select2-container {width: 100% !important}
  </style>
  <body>

    @auth('admin')
      @include('layouts.admin.side_menu')
      @include('layouts.admin.header')
      {{-- @include('layouts.admin.notifactions_panel') --}}
    @endauth

    @yield('admin_content')
    <script src="{{asset('backend/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('backend/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('backend/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('backend/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('backend/lib/highlightjs/highlight.pack.js')}}"></script>
    <script src="{{asset('backend/lib/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/lib/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('backend/lib/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('backend/lib/spectrum/spectrum.js')}}"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/datatables.min.js"></script>    

    <script>
      $(function(){

        'use strict';

        $('.select2').select2({
          minimumResultsForSearch: Infinity
        });

        // Select2 by showing the search
        $('.select2-show-search').select2({
          minimumResultsForSearch: ''
        });

        // Select2 with tagging support
        $('.select2-tag').select2({
          tags: true,
          tokenSeparators: [',', ' '],
        });

        $('.select2-tag').on('select2:open select2:opening', function( event ) {
          $('.select2-results').css('display', 'none');
        });

        $("#select2insidemodal").select2({
        dropdownParent: $("#modaldemo3")
        });

        $(".select2_empty").select2({
          allowClear: true,
        });

        // Datepicker
        $('.fc-datepicker').datepicker({
          dateFormat: "dd/mm/yy"   
        });

        // Color picker
        $('#colorpicker').spectrum({
          color: '#17A2B8'
        });

        $('#showAlpha').spectrum({
          color: 'rgba(23,162,184,0.5)',
          showAlpha: true
        });

        $('#showPaletteOnly').spectrum({
            showPaletteOnly: true,
            showPalette:true,
            color: '#DC3545',
            palette: [
                ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
                ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
            ]
        });

      });
    </script>


    <script src="{{asset('backend/lib/medium-editor/medium-editor.js')}}"></script>
    <script src="{{asset('backend/lib/summernote/summernote-bs4.min.js')}}"></script>

    <script>
      $(function(){
        'use strict';

        // Inline editor
        var editor = new MediumEditor('.editable');

        // Summernote editor
        $('#summernote').summernote({
          height: 150,
          tooltip: false
        })
      });
    </script>

    <script src="{{asset('backend/lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('backend/lib/d3/d3.js')}}"></script>
    <script src="{{asset('backend/lib/rickshaw/rickshaw.min.js')}}"></script>
    <script src="{{asset('backend/lib/chart.js/Chart.js')}}"></script>
    <script src="{{asset('backend/lib/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('backend/lib/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('backend/lib/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('backend/lib/flot-spline/jquery.flot.spline.js')}}"></script>

    <script src="{{asset('backend/js/starlight.js')}}"></script>
    <script src="{{asset('backend/js/ResizeSensor.js')}}"></script>
    {{-- <script src="{{asset('backend/js/dashboard.js')}}"></script> --}}
    @stack('charts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>
    <script>
      $(function(){
        'use strict';

        var datatable1 = $('#datatable1').DataTable({
          dom: 'lBfrtip',
          lengthMenu: [ 10, 25, 50, 100],
          responsive: true,
          buttons: [
            'copy','excel','pdf','print','colvis'
          ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          },
        });

        var datatable2 = $('#datatable2').DataTable({
          dom: 'lBfrtip',
          lengthMenu: [ 10, 25, 50, 100],
          responsive: true,
          buttons: [
            'copy','excel','pdf','print','colvis'
          ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          },
          columnDefs: [{
            'targets': 0,
            "width": "1%",
            'searchable':false,
            'orderable':false,
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
          }],
        });

        $('#datatableAjax').DataTable({
              dom: 'lBfrtip',
              lengthMenu: [ 10, 25, 50, 100],
              responsive: true,
              processing: true,
              serverSide: true,
              ajax: `{{ request()->url() }}`,
              @stack('datatableAjax')
              buttons: [
                  'copy','excel','pdf','print','colvis'
              ],
              language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
                processing: `
                  <span class="text-primary" style="position:absolute;left: 50%;top:50%">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                  </span>
                  `,
              },
              initComplete: function () {
                $('#fa-spin').hide()
              }
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

        $('#select-all').on('click', function(){
          var rows = datatable2.rows({ 'search': 'applied', page: 'current' }).nodes();
          $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $(document).on('change', 'input[type="checkbox"]', function(){

          // If checkbox is not checked
          if(!this.checked) {
              var el = $('#select-all').get(0);
              // If "Select all" control is checked and has 'indeterminate' property
              if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
              }

          }

          $('button.select-all').attr('disabled', !this.checked)

        });
        
        // Handle form submission event
        $('button.select-all').on('click', function(e){
          e.preventDefault();

          swal({
            title:  "Are You Sure  You Want To Delete All Selected Items?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {

              var form =  $(this).closest("form");

              datatable2.$('input[type="checkbox"]').each(function(){
                  if(this.checked){
                      form.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', this.name)
                            .val(this.value)
                      );
                  }
              });
              form.submit();
            }
          });
        });
      });
    </script>


    <script>
        @if(Session::has('message'))
          var type="{{Session::get('alert-type','info')}}"
          switch(type){
              case 'info':
                   toastr.info("{{ Session::get('message') }}");
                   break;
              case 'success':
                  toastr.success("{{ Session::get('message') }}");
                  break;
              case 'warning':
                 toastr.warning("{{ Session::get('message') }}");
                  break;
              case 'error':
                  toastr.error("{{ Session::get('message') }}");
                  break;
          }
        @endif
        @if(Session::has('verified') === true)
          toastr.success("Your Email Has Been Successfully Verified");
        @endif
     </script>  

    <script>  
      function sure(myclass) {
        $(document).on("click", myclass, function(e){
                  e.preventDefault();
                  //  var link = $(this).attr("href") ?? $(this).attr("action");
                  var form =  $(this).closest("form");
                  var title = "";
                  var text = "";
                  var danger = false;
                  switch (myclass) {
                    case ".approve":
                      title = "Are You Sure You  Want To Approve This Request?";
                      text = "The Order Will Be Canceled";
                      break;
                    case ".refuned":
                      title = "Are You Sure You  Payment Is Refunded?";
                      break;
                    case ".reject":
                      title = "Are You Sure You  Want To Reject This Request?";
                      danger = true;
                      break;

                    case ".cancel":
                      title = "Are You Sure You  Want To Cancel This Order?";
                      danger = true;
                      break;
                    case ".pay":
                      title = "Are You Sure You  Want To Accept Payment To This Order?";
                      break;
                    case ".ship":
                      title = "Are You Sure You  Want To Start Shipping This Order?";
                      break;
                    case ".deliver":
                      title = "Are You Sure This Order Is Delivered?";
                      break;
                  
                    default:
                      title = "Are You Sure You  Want To Delete This Item?";
                      danger = true;
                      break;
                  }

                      swal({
                        title:  title,
                        text: text,
                        icon: "warning",
                        buttons: true,
                        dangerMode: danger,
                      })
                      .then((willDelete) => {
                        if (willDelete) {
                            //  window.location.href = link;
                            var formaction = $(this).attr('formaction')
                            if (formaction) {
                              form.attr('action', formaction)
                            }
                            form.submit();
                        }
                      });
                  });
      }
      sure(".delete");

      sure(".approve");
      sure(".refuned");
      sure(".reject");

      sure(".cancel");
      sure(".pay");
      sure(".ship");
      sure(".deliver");
    </script>
  </body>
</html>
