@include('admin.block.header')
    <div class="container-fluid">
        <!-- menu -->
        <!-- end menu -->
        <div class="container">
            <!-- container -->
            <div class="row">
                <!-- leftbar -->
                <div class="col-md-3">

                </div>
                <!-- end left bar -->
                <!-- content -->
                <div class="col-md-9 content-right">
                    @yield('content')
                </div>
                <!-- end contain -->
            </div>
        <!-- encontainer -->
        </div>
    </div>
    @section('contentJs')
        {{ Html::script('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
        {{ Html::script('/common/js/common.js') }}
        {{ Html::script('/common/js/bootbox.min.js') }}
        {{ Html::script('/jquery-colorbox/jquery.colorbox-min.js') }}
    @show
    <!-- end js  -->
    <script type="text/javascript">
        $.ajaxSetup ({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@include('admin.block.footer')
