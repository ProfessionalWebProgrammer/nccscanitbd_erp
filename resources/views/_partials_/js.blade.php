<!-- jQuery -->
<script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('public/backend/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS   -->
<script src="{{ asset('public/backend/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/backend/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/backend/dist/js/pages/dashboard3.js') }}"></script>

{{-- NEw --}}
<!-- Bootstrap 4 -->
<!-- DataTables  & Plugins -->

<script src="{{ asset('public/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('public/backend/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- date-range-picker -->
{{-- <script src="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
<!-- InputMask -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script src="{{ asset('public/backend/plugins/moment/moment.min.js') }}"></script> --}}
{{-- <script src="{{ asset('public/backend/plugins/inputmask/jquery.inputmask.min.js') }}"></script> --}}


<!-- AdminLTE App -->
<!-- SweetAlert2 -->
<script src="{{ asset('public/backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('public/backend/plugins/toastr/toastr.min.js') }}"></script>

{{-- <script src="{{ asset('public/backend/dist/js/adminlte.min.js') }}"></script> --}}
<!-- Page specific script -->

<script src="{{ asset('public/selectpicker/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('public/selectpicker/js/i18n/defaults-*.min.js') }}"></script>

<script src="{{asset('public/js/table2excel.js')}}"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js" integrity="sha512-16cHhHqb1CbkfAWbdF/jgyb/FDZ3SdQacXG8vaOauQrHhpklfptATwMFAc35Cd62CQVN40KDTYo9TIsQhDtMFg==" crossorigin="anonymous"></script>
  

{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}


<script>
    $(function() {
        $("#example1").DataTable({
           // "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        
         $('#exampleWithoutPag').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
             "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#exampleWithoutPag_wrapper .col-md-6:eq(0)');;


        $("#example3").DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');

        $('#example5').DataTable({
            "searching": true,
            "lengthMenu": [5, 10, 50]

        });
        
         $("#example8").DataTable({
           // "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "info": false,
            "ordering": false,
        }).buttons().container().appendTo('#example8_wrapper .col-md-6:eq(0)');
        
		$("#datatable7").DataTable({
                "lengthChange": false,
                "autoWidth": false,
              //  "responsive": true,
                "autoWidth": false,

        
           		"iDisplayLength": -1,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#datatablecustom_wrapper .col-md-6:eq(0)');

        $("#datatablecustom").DataTable({
                "lengthChange": false,
                "autoWidth": false,
              //  "responsive": true,
                "autoWidth": false,

        
           		"iDisplayLength": -1,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#datatablecustom_wrapper .col-md-6:eq(0)');


        $('#daterangepicker').daterangepicker({
            timePicker: false,

            locale: {
                format: 'Y-MM-DD'
            }
        });
    });
</script>


<script>
    function showTime() {
        // to get current time/ date.
        var date = new Date();
        // to get the current hour
        var h = date.getHours();
        // to get the current minutes
        var m = date.getMinutes();
        //to get the current second
        var s = date.getSeconds();
        // AM, PM setting
        var session = "AM";

        //conditions for times behavior 
        if (h == 0) {
            h = 12;
        }
        if (h >= 12) {
            session = "PM";
        }

        if (h > 12) {
            h = h - 12;
        }
        m = (m < 10) ? m = "0" + m : m;
        s = (s < 10) ? s = "0" + s : s;

        //putting time in one variable
        var time = h + ":" + m + ":" + s + " " + session;
        //putting time in our div
        $('#clock').html(time);
        //to change time in every seconds
        setTimeout(showTime, 1000);
    }
    showTime();
</script>


<script>
    $(function() {

        $('.select2').select2({
            theme: 'bootstrap4'
        })


     

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });





    });
</script>


    
 

 <script>
  $(document).ready(function() {
    $('.hovermanu').mouseenter(function(){
      $('.hover_manu_content').css("opacity", "1");
      $('.hover_manu_content').css("top", "0");
      $('.hover_manu_content').css("position", "0");
      $('.hover_manu_content').css("z-index", "999999999999");
      $('.hover_manu_content').css("transition", "all .5s");
   });
   $('.hovermanu').mouseleave(function(){
      $('.hover_manu_content').mouseleave(function(){
          $('.hover_manu_content').css("opacity", "0");
         $('.hover_manu_content').css("top", "-390px");
      $('.hover_manu_content').css("z-index", "0");
        
          $('.hover_manu_content').css("transition", "all .5s");
        
     });
    });
    
  }); 
</script>



 




@include('_partials_.sweetalertjs')



@stack('end_js')
