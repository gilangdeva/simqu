        <footer class="footer text-center">{{ date("Y") }} &copy; SIMQU Inspection | HR Business Analyst - PT. Solo Murni </footer>
    </div> <!-- /Page Wrapper -->
</div> <!-- /Wrapper -->

    <!-- jQuery -->
    <script src="{{ url('/') }}/admin/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('/') }}/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ url('/') }}/admin/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--Counter js -->
    <script src="{{ url('/') }}/admin/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ url('/') }}/admin/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{ url('/') }}/admin/js/waves.js"></script>
    <!--Morris JavaScript -->
    <script src="{{ url('/') }}/admin/bower_components/raphael/raphael-min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/morrisjs/morris.js"></script>

    <!-- chartist chart -->
    <script src="{{ url('/') }}/admin/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="{{ url('/') }}/admin/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script> //
    <!-- Custom Theme JavaScript -->
    <script src="{{ url('/') }}/admin/js/custom.js"></script>
    {{-- <script src="{{ url('/') }}/admin/js/custom.min.js"></script> --}}
    <script src="{{ url('/') }}/admin/js/jasny-bootstrap.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/switchery/dist/switchery.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="{{ url('/') }}/admin/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="{{ url('/') }}/admin/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script src="{{ url('/') }}/admin/bower_components/multiselect/js/jquery.multi-select.js" type="text/javascript"></script>
    <!-- Data tables -->
    <script src="{{ url('/') }}/admin/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!--Style Switcher -->
    <script src="{{ url('/') }}/admin/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ url('/') }}/admin/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{ url('/') }}/admin/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Data Mask -->
    <script src="{{ url('/') }}/admin/js/mask.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="{{ url('/') }}/admin/bower_components/datatables/dataTables.buttons.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/datatables/buttons.flash.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/datatables/jszip.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/datatables/pdfmake.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/datatables/vfs_fonts.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/datatables/buttons.html5.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/datatables/buttons.print.min.js"></script>
    <!-- toastr -->
    <script src="{{ url('/') }}/admin/js/toastr.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/toast-master/js/jquery.toast.js"></script>
    <!-- jQuery file upload -->
    <script src="{{ url('/') }}/admin/bower_components/dropify/dist/js/dropify.min.js"></script>
    <!-- Footable -->
    <script src="{{ url('/') }}/admin/bower_components/footable/js/footable.all.min.js"></script>
    <script src="{{ url('/') }}/admin/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--FooTable init-->
    <script src="{{ url('/') }}/admin/js/footable-init.js"></script>
    
    <!-- End - This is for export functionality only -->

    <script>
        $(document).ready(function() {
            // Datatable Basic
            $('#tablebasic').DataTable();

            // For select 2
            $(".select2").select2();
            $('.selectpicker').selectpicker();

            // File Upload Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
</body>

</html>