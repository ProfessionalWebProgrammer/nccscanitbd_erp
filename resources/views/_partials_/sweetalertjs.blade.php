
@if(session()->has('success'))
    <script type="text/javascript">

    $(function() {
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
        });
            $(function () {
                Toast.fire({
                    icon: 'success',
                        // title: "Success",
                        text: "{{ session()->get('success') }}",
                        type: "success"})

            });

        });
    </script>
    {{session()->forget('success');}}
@endif


@if(session()->has('warning'))
    <script type="text/javascript">

    $(function() {
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
        });
            $(function () {
                Toast.fire({
                    icon: 'warning',
                        // title: "Success",
                        text: "{{ session()->get('warning') }}",
                        type: "warning"})

            });

        });
    </script>
    {{session()->forget('warning');}}
@endif
