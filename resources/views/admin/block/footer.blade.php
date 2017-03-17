		<!-- start js  -->
		{{ Html::script('/assets/js/common/bootstrap.js') }}
		{{ Html::script('/assets/js/common/bootstrap.min.js') }}
		{{ Html::script('/assets/js/common/common.js') }}
		
		@yield('contentJs')
		<!-- end js  -->
	</body>
</html>