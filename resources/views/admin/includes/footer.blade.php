        <!-- jQuery -->
        <script src="{{asset('public/admin/assets/js/jquery-3.6.0.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{asset('public/admin/assets/js/bootstrap.bundle.min.js')}}"></script>
		
		<!-- Feather Icon JS -->
		<script src="{{asset('public/admin/assets/js/feather.min.js')}}"></script>
		
		<!-- Slimscroll JS -->
		<script src="{{asset('public/admin/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
		
		<!-- Select2 JS -->
		<script src="{{asset('public/admin/assets/plugins/select2/js/select2.min.js')}}"></script>
		<!-- autofill cdn -->

		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> 



        <!-- Datatables JS -->
		<script src="{{asset('public/admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('public/admin/assets/plugins/datatables/datatables.min.js')}}"></script>
		<script src="https://cdn.datatables.net/fixedheader/3.2.2/js/dataTables.fixedHeader.min.js"></script>

		<script>
			$(document).ready(function() {
				// Check if DataTable is already initialized
				if ($.fn.DataTable.isDataTable('#header_lock')) {
					console.log('Destroying existing DataTable');
					$('#header_lock').DataTable().destroy();
				}

				// Initialize DataTable
				$('#header_lock').DataTable({
					"scrollY": '100%',
					"scrollX": '100%',
					"scrollCollapse": false,
					"searching": true,
					"fixedHeader": true,
					"stateSave": true
				});

				console.log('DataTable initialized');
			});
	</script>


		<script src="{{asset('public/admin/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
		<script src="{{asset('public/admin/assets/plugins/apexchart/chart-data.js')}}"></script>
		
		<!-- Custom JS -->
		<script src="{{asset('public/admin/assets/js/script.js')}}"></script>

		{{-- Date Picker --}}

		<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">

		

	</body>
</html>